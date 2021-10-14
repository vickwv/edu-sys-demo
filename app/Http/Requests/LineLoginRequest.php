<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 功能：Line登陆
 *
 * @author: stevenv
 * @date: 2021-10-10
 **/
class LineLoginRequest extends FormRequest
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
            "id"       => "required|integer",
            "provider" => "required|in:teacher,student",
            "code"     => 'required|string',
        ];
    }
}
