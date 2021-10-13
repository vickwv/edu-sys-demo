<?php


namespace App\Admin\Services;

use App\Model\TeacherModel;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Role;
use Illuminate\Support\Facades\DB;

/**
 * 功能：管理员
 *
 * @author: stevenv
 * @date: 2021-10-13
 **/
class AdminUserService
{
    public function teacherToAdmin(int $teacherId) {
        DB::beginTransaction();
        try {
            $teacher = TeacherModel::find($teacherId);
            if (! empty($teacher)) {
                $admin = Administrator::where('username', $teacher->email)->first();
                if (empty($admin)) {
                    $admin = Administrator::create([
                        'username' => $teacher->email,
                        'password' => $teacher->password,
                    ]);
                }

                $role = Role::where('slug', 'school_admin')->first();
                $admin->roles();
                $admin->roles()->attach($role->id);
            }
            DB::commit();

        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
        }
    }
}