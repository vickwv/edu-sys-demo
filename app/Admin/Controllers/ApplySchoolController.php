<?php

namespace App\Admin\Controllers;

use App\Admin\Services\AdminUserService;
use App\Http\Constants\ApplySchoolStatusEnum;
use App\Model\ApplySchoolModel;
use App\Model\TeacherModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ApplySchoolController extends AdminController
{

    protected $beforeStatus;
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '申请单(学校)管理';

    protected function getTeacherMap() {
        return TeacherModel::all()->pluck('name', 'id')->all();
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ApplySchoolModel);

        $grid->column('id', __('申请单id'));
        $grid->column('teacher_id', __('老师名称'))->using($this->getTeacherMap());
        $grid->column('school_name', __('学校名称'));
        $grid->column('school_province', __('学校省份'));
        $grid->column('school_city', __('学校城市'));
        $grid->column('school_area', __('学校地区'));
        $grid->column('school_address', __('学校地址'));
        $grid->column('status', __('状态'))->using(ApplySchoolStatusEnum::getStatsDesc());
        $grid->column('reason', __('拒绝原因'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(ApplySchoolModel::findOrFail($id));

        $show->field('id', __('申请单id'));
        $show->field('teacher_id', __('老师名称'))->using($this->getTeacherMap());
        $show->field('school_name', __('学校名称'));
        $show->field('school_province', __('学校省份'));
        $show->field('school_city', __('学校城市'));
        $show->field('school_area', __('学校地区'));
        $show->field('school_address', __('学校地址'));
        $show->field('status', __('状态'))->using(ApplySchoolStatusEnum::getStatsDesc());
        $show->field('reason', __('拒绝原因'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ApplySchoolModel);
        $form->display('id', __('申请单id'));
        $form->select('teacher_id', __('老师id'))
            ->options($this->getTeacherMap())
            ->readOnly();
        $form->text('school_name', __('学校名称'))->rules('required|string|max:20', [
            'max' => '最大20个字',
            'required' => '不能为空',
        ]);
        $form->text('school_province', __('学校省份'))->rules('required|string|max:16', [
            'max' => '最大16个字',
            'required' => '不能为空',
        ]);
        $form->text('school_city', __('学校城市'))->rules('required|string|max:16', [
            'max' => '最大16个字',
            'required' => '不能为空',
        ]);
        $form->text('school_area', __('学校地区'))->rules('required|string|max:16', [
            'max' => '最大16个字',
            'required' => '不能为空',
        ]);
        $form->text('school_address', __('学校地址'))->rules('required|string|max:32', [
            'max' => '最大32个字',
            'required' => '不能为空',
        ]);
        //状态：0待审核,1通过,2拒绝
        $form->radio('status', __('状态'))
            ->options(ApplySchoolStatusEnum::getStatsDesc())
            ->rules('required', ['required' => '请选择状态'])
            ->value(ApplySchoolStatusEnum::STATUS_PASS)->disable();
        $form->text('reason', __('拒绝原因'))->rules('nullable|string', [
            'string' => '请输入字符串'
        ]);

        $form->saving(function (Form $form) {
            $this->beforeStatus = $form->model()->status;
        });
        $form->saved(function (Form $form) {
            if ($this->beforeStatus != $form->status && $form->status == ApplySchoolStatusEnum::STATUS_PASS) {
                app(AdminUserService::class)->teacherToAdmin($form->teacher_id);
            }
        });
        return $form;
    }
}
