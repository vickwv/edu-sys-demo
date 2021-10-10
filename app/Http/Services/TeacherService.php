<?php


namespace App\Http\Services;


use App\Exceptions\RegisterFailException;
use App\Http\Model\TeacherModel;

class TeacherService
{
    /**
     * 功能：注册逻辑
     *
     * @author: stevenv
     * @date: 2021-10-10
     **/
    public function register(array $params) {
        $teacher = app(TeacherModel::class);
        $isExist = $teacher->where('email', $params['email'])->exists();
        if ($isExist) {
            throw new RegisterFailException();
        }

        $params['password'] = bcrypt($params['password']);

        $teacher = $teacher->create($params);
        if (empty($teacher)) {
            throw new RegisterFailException();
        }
        return [
            'token_type' => 'Bearer',
            'access_token' => $teacher->createToken("Laravel Password Grant Client")->accessToken,
        ];
    }
}