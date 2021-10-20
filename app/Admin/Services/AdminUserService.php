<?php


namespace App\Admin\Services;

use App\Model\Teacher;
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
    public function teacherToAdmin(int $teacherId) {
        DB::beginTransaction();
        try {
            $teacher = Teacher::find($teacherId);
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

        } catch (Exception $e) {
            app('log')->error('老师变成管理员失败: ' . $e->getMessage());
            DB::rollBack();
        }
    }
}