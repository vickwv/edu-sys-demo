<?php


namespace App\Http\Services;

use App\Exceptions\BusinessException;
use App\Http\Constants\RedisKeyEnum;
use App\Http\Constants\RoleEnum;
use App\Http\Model\TeacherInviteModel;
use App\Http\Model\TeacherModel;
use Illuminate\Support\Facades\Redis;

class TeacherInviteService
{
    // 状态:0待接受,1邀请成功,2邀请过期
    protected const STATUS_INIT = 0;
    protected const STATUS_SUCCESS = 1;
    protected const STATUS_EXPIRE = 2;

    /**
     * <p>
     *  邀请用户
     * </p>
     *
     * @param int $teacherId
     * @param string $email
     * @return string
     * @author: wangwei
     * @date: 2021-10-12
     */
    public function invite(int $teacherId, string $email): string {

        $invite = TeacherInviteModel::where([
            'teacher_id' => $teacherId,
            'email'      => $email,
        ])->first();
        if (! empty($invite)) {
            if ($invite->stats == self::STATUS_EXPIRE) {
                $invite->status = self::STATUS_INIT;
            }
            $invite->save();
        } else {
            TeacherInviteModel::create([
                'teacher_id' => $teacherId,
                'email'      => $email,
                'status'     => self::STATUS_INIT,
            ]);
        }

        $token = uniqid("activate_", true);
        $key = RedisKeyEnum::TEACHER_INVITE_TOKEN . $email;
        Redis::set($key, $token, 30 * 60);

        return url("teacher/activation", [
            "token" => $token,
            "email" => $email,
        ]);
    }

    /**
     * <p>
     *  激活用户
     * </p>
     *
     * @param string $token
     * @param string $email
     * @return array
     * @throws BusinessException
     * @author: wangwei
     * @date: 2021-10-12
     */
    public function activation(string $token, string $email) {
        $key = RedisKeyEnum::TEACHER_INVITE_TOKEN . $email;
        $originToken = Redis::get($key);
        if (empty($originToken) || $token != $originToken) {
            throw new BusinessException("邀请已过期，请重新邀请");
        }

        $password = str_random(12);
        TeacherModel::create([
            'email' => $email,
            'name' => 'user_' . str_random(10),
            'role' => RoleEnum::ROLE_TEACHER,
            'password' => bcrypt($password),
        ]);
        Redis::del($key);

        return [
            'password' => $password,
        ];
    }
}
