<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 功能：关注老师
 *
 * @author: stevenv
 * @date: 2021-10-14
 **/
class FollowTeacherRequest extends FormRequest
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
            'teacher_id' => 'required|integer',
            'is_follow'  => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'teacher_id.required' => '请选择要关注的老师',
            'teacher_id.integer'  => '好像不知道你要选择哪个老师呢?',
            'is_follow.required'  => '你想不想关注呢?',
            'is_follow.integer'   => '你想不想关注呢?',
        ];
    }
}
