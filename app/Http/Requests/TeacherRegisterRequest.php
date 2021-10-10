<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 功能：老师注册
 *
 * @author: stevenv
 * @date: 2021-10-10
 **/
class TeacherRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'name'     => 'required|string|min:3',
            'age'      => 'required|integer|max:120|min:0',
            'sex'      => 'required|integer|in:1,0'
        ];
    }

    public function messages()
    {
        return [
            'email.required'     => '必须填写邮箱',
            'email.email'        => '邮箱格式错误',
            'password.required'  => '必须填写密码',
            'password.min'       => '密码至少八位',
            'password.confirmed' => '两次输入的密码不一致',
            'name.required'      => '必须填写名称',
            'name.min'           => '名称最少为三位',
            'age.required'       => '必须填写年龄',
            'sex.required'       => '必须填写性别',
            'age.integer'        => '年龄必须为数字',
            'age.max'            => '年龄不能超过120',
            'age.min'            => '年龄不能小于0',
            'sex.integer'        => '请选择男或女',
        ];
    }
}
