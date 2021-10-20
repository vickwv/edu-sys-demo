<?php


namespace App\Http\Services;

use App\Exceptions\BusinessException;
use App\Http\Constants\GlobalEnum;
use App\Http\Constants\RedisKeyEnum;
use App\Http\Constants\RoleEnum;
use App\Model\TeacherInvite;
use Illuminate\Support\Facades\Redis;

/**
 * 功能：邀请老师业务逻辑
 *
 * @author: stevenv
 * @date: 2021-10-12
 **/
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
     * @throws BusinessException
     * @author: wangwei
     * @date: 2021-10-12
     */
    public function invite(int $teacherId, string $email): string {
        $invite = TeacherInvite::where([
            'teacher_id' => $teacherId,
            'email'      => $email,
        ])->first();

        if (! empty($invite)) {
            if ($invite->stats == self::STATUS_EXPIRE) {
                $invite->status = self::STATUS_INIT;
                $invite->save();
            }
        } else {
            $invite = TeacherInvite::create([
                'teacher_id' => $teacherId,
                'email'      => $email,
                'status'     => self::STATUS_INIT,
            ]);
        }

        if ($invite->status == self::STATUS_SUCCESS) {
            throw new BusinessException("邀请的用户已经注册");
        }

        $token = uniqid("activate_", true);
        $key = RedisKeyEnum::TEACHER_INVITE_TOKEN . $token;

        Redis::setex($key, 30 * 60, $invite->id);
        $url = url("api/teacher_invite/accept") . "?" . http_build_query(["token" => $token]);
        if ($invite->is_sent == GlobalEnum::NO) {
            $content = "EDU SYSTEM 邀请链接:" . $url;
            $subject = "您的好友邀请您加入EDU SYSTEM";
            app(MailService::class)->sendText($subject, $content, '15179279769@139.com', $email, 'EDU-SYSTEM');
            $invite->is_sent = GlobalEnum::YES;
            $invite->save();
        }

        return $url;
    }

    /**
     * <p>
     *   接受邀请
     * </p>
     *
     * @param string $token
     * @return array
     * @throws BusinessException
     * @author: wangwei
     * @date  : 2021-10-12
     */
    public function accept(string $token): array {
        $key = RedisKeyEnum::TEACHER_INVITE_TOKEN . $token;
        $inviteId = Redis::get($key);
        if (empty($inviteId)) {
            throw new BusinessException("邀请已过期，请重新邀请");
        }

        $invite = TeacherInvite::find($inviteId);
        if (empty($invite) || $invite->status == self::STATUS_EXPIRE) {
            throw new BusinessException("邀请已过期，请重新邀请");
        }

        $password = str_random(12);
        try {
            app(TeacherService::class)->registerTeacher([
                'email'    => $invite->email,
                'name'     => 'user_' . str_random(10),
                'password' => $password,
            ]);
        } catch (BusinessException $e) {
            // 已经注册也要更改邀请状态
            Redis::del($key);
            $invite->status = self::STATUS_SUCCESS;
            $invite->save();

            throw $e;
        }

        Redis::del($key);
        $invite->status = self::STATUS_SUCCESS;
        $invite->save();

        return [
            'password' => $password,
        ];
    }
}
