<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * <p>
 *  邀请老师
 * </p>
 *
 * @author: wangwei
 * @date: 2021-10-12
 */
class InviteTeacherRequest extends FormRequest
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
        ];
    }

    public function messages()
    {
        return [
            'email.required'     => '必须填写邮箱',
            'email.email'        => '邮箱格式错误',
        ];
    }
}