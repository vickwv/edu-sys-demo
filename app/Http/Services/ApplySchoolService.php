<?php

/**
 * 功能：申请学校服务层
 *
 * @author: stevenv
 * @date: 2021-10-10
 **/

namespace App\Http\Services;

use App\Exceptions\BusinessException;
use App\Http\Model\ApplySchoolModel;
use Illuminate\Support\Facades\Auth;

class ApplySchoolService
{
    public function create(array $params) {
        $data = [
            'teacher_id' => Auth::id(),
        ];
        foreach ($params as $k => $v) {
            $data['school_' . $k] = $v;
        }

        $exist = ApplySchoolModel::where([
            'teacher_id'  => $data['teacher_id'],
            'school_name' => $data['school_name'],
        ])->exists();
        if ($exist) {
            throw new BusinessException("请不要重复申请");
        }
        $apply = ApplySchoolModel::create($data);
        if (empty($apply)) {
            throw new BusinessException("创建申请单失败");
        }

        return [
            'id' => $apply->id,
        ];
    }
}