<?php


namespace App\Admin\Services;

use App\Model\ApplySchoolModel;
use App\Model\SchoolModel;

/**
 * 功能：申请单业务逻辑
 *
 * @author: stevenv
 * @date: 2021-10-15
 **/
class ApplySchoolService
{

    /**
     * 功能：保存成功后的业务逻辑
     *
     * @author: stevenv
     * @date  : 2021-10-15
     * @param ApplySchoolModel $applySchool
     */
    public function afterSavedHandle(ApplySchoolModel $applySchool) {
        // 给老师添加管理员权限
        app(AdminUserService::class)->teacherToAdmin($applySchool->teacher_id);
        // 学校添加到学校表
        app(SchoolModel::class)->create([
            'name'     => $applySchool->school_name,
            'province' => $applySchool->school_province,
            'city'     => $applySchool->school_city,
            'area'     => $applySchool->school_area,
            'address'  => $applySchool->school_address,
        ]);
    }
}