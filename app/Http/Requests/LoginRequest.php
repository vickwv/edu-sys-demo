<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 功能：登陆
 *
 * @author: stevenv
 * @date: 2021-10-10
 **/
class LoginRequest extends FormRequest
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
            "email"    => "required|email",
            "password" => "required|min:8",
            "provider" => "required|in:teacher,student",
        ];
    }

    public function messages()
    {
        return [
            'email.required'     => '必须填写邮箱',
            'email.email'        => '邮箱格式错误',
            'password.required'  => '必须填写密码',
            'password.min'       => '密码至少八位',
            'provider.required'  => '请选择身份，老师或学生',
            'provider.in'        => '未知身份',
        ];
    }
}
