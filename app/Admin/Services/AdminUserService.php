<?php


namespace App\Admin\Services;

use App\Model\TeacherModel;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Role;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * 功能：管理员
 *
 * @author: stevenv
 * @date: 2021-10-13
 **/
class AdminUserService
{

    /**
     * 功能：给老师添加管理员权限
     *
     * @author: stevenv
     * @date  : 2021-10-15
     * @param int $teacherId
     */
    public function teacherToAdmin(int $teacherId) {
        $teacher = TeacherModel::find($teacherId);
        if (! empty($teacher)) {
            $admin = Administrator::where('username', $teacher->email)->first();
            if (empty($admin)) {
                $admin = Administrator::create([
                    'username' => $teacher->email,
                    'password' => $teacher->password,
                    'name'     => $teacher->name,
                ]);
            }

            $role = Role::where('slug', 'school_admin')->first();
            $admin->roles();
            $admin->roles()->attach($role->id);
        }
    }
}