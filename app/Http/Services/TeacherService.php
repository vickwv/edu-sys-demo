<?php


namespace App\Http\Services;


use App\Exceptions\BusinessException;
use App\Exceptions\RegisterFailException;
use App\Http\Constants\GlobalEnum;
use App\Model\Teacher;

class TeacherService
{

    /**
     * 功能：注册逻辑
     *
     * @param array $params
     * @return array
     * @throws RegisterFailException|BusinessException
     * @author: stevenv
     * @date  : 2021-10-10
     */
    public function registerTeacher(array $params) : array {
        $teacherModel = app(Teacher::class);
        $isExist = $teacherModel->where('email', $params['email'])->exists();
        if ($isExist) {
            throw new BusinessException("该邮箱已经被注册");
        }

        $params['password'] = bcrypt($params['password']);
        $params['status'] = GlobalEnum::YES;
        $teacherModel = $teacherModel->create($params);
        if (empty($teacherModel)) {
            throw new RegisterFailException();
        }

        return [
            'access_token' => 'Bearer '. $teacherModel->createToken("Laravel Password Grant Client")->accessToken,
        ];
    }
}