<?php


namespace App\Http\Services;


use App\Exceptions\BusinessException;
use App\Exceptions\RegisterFailException;
use App\Http\Model\TeacherModel;

class TeacherService
{

    /**
     * 功能：注册逻辑
     *
     * @author: stevenv
     * @date  : 2021-10-10
     * @param array $params
     * @return array
     * @throws RegisterFailException
     */
    public function registerTeacher(array $params) {
        $teacher = app(TeacherModel::class);
        $isExist = $teacher->where('email', $params['email'])->exists();
        if ($isExist) {
            throw new BusinessException("该邮箱已经被注册");
        }

        $params['password'] = bcrypt($params['password']);

        $teacher = $teacher->create($params);
        if (empty($teacher)) {
            throw new RegisterFailException();
        }

        return [
            'token_type'   => 'Bearer',
            'access_token' => $teacher->createToken("Laravel Password Grant Client")->accessToken,
        ];
    }
}