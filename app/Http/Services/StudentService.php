<?php

namespace App\Http\Services;

use App\Exceptions\BusinessException;
use App\Http\Constants\GlobalEnum;
use App\Model\TeacherFollowModel;
use App\Model\TeacherModel;
use Illuminate\Support\Facades\Auth;

class StudentService
{

    /**
     * 功能：关注老师
     *
     * @author: stevenv
     * @date  : 2021-10-14
     * @param int $teacherId
     * @param int $isFollow
     * @return bool
     * @throws BusinessException
     */
    public function followTeacher(int $teacherId, int $isFollow) {
        $teacher = TeacherModel::find($teacherId);
        if (empty($teacher)) {
            throw new BusinessException("您关注的老师不存在");
        }

        $student = Auth::user();
        $follow = TeacherFollowModel::updateOrCreate([
            'teacher_id' => $teacherId,
            'student_id' => $student->id,
        ], ['is_follow'  => $isFollow]);

        return $follow->is_follow;
    }

    /**
     * 功能：获取关注的老师
     *
     * @author: stevenv
     * @date: 2021-10-14
     **/
    public function getFollowTeachers() {
        $student = Auth::user();
        $teachers = $student->teachers()->where('is_follow', GlobalEnum::YES)->get();
        foreach ($teachers as $teacher) {
            unset($teacher->created_at, $teacher->created_at, $teacher->pivot, $teacher->email);
        }

        return $teachers->toArray();
    }
}