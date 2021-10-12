<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * <p>
 *  接受邀请
 * </p>
 *
 * @author: wangwei
 * @date: 2021-10-12
 */
class AcceptInviteRequest extends FormRequest
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
            "token"    => "required|string",
        ];
    }

    public function messages()
    {
        return [
            'token.required'     => '邀请链接已经失效',
        ];
    }
}