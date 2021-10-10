<?php

namespace App\Http\Requests;

use App\Rules\NoEmoji;
use App\Rules\NoXss;
use Illuminate\Foundation\Http\FormRequest;

/**
 * 功能：创建申请学校单
 *
 * @author: stevenv
 * @date: 2021-10-10
 **/
class CreateApplySchoolRequest extends FormRequest
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
        $noXss = new NoXss();
        $noEmoji = new NoEmoji();
        return [
            'name'     => ['required', 'string', 'min:2', 'max:20', $noEmoji, $noXss],
            'province' => ['required', 'string', 'min:2', 'max:16', $noEmoji, $noXss],
            'city'     => ['required', 'string', 'min:2', 'max:16', $noEmoji, $noXss],
            'area'     => ['required', 'string', 'min:2', 'max:16', $noEmoji, $noXss],
            'address'  => ['required', 'string', 'min:3', 'max:32', $noEmoji, $noXss]
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => '请填写学校名称',
            'province.required' => '请填写学校所在省份',
            'city.required'     => '请填写学校所在城市',
            'area.required'     => '请填写学校所在地区',
            'address.required'  => '请填写学校详细地址',
            'name.min'          => '学校名称最少为2位',
            'province.min'      => '学校所在省份最少为2位',
            'city.min'          => '学校所在城市最少为2位',
            'area.min'          => '学校所在地区最少为2位',
            'address.min'       => '学校详细地址最少为2位',
            'name.max'          => '学校名称最大为20位',
            'city.max'          => '学校所在城市最多为16位',
            'area.max'          => '学校所在地区最多为16位',
            'province.max'      => '学校所在省份最多为16位',
            'address.max'       => '学校详细地址最多32位',
        ];
    }
}
