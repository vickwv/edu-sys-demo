<?php

namespace App\Admin\Controllers;

use App\Admin\Services\ApplySchoolService;
use App\Http\Constants\ApplySchoolStatusEnum;
use App\Model\ApplySchool;
use App\Model\Teacher;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;

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
        return Teacher::all()->pluck('name', 'id')->all();
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ApplySchool);

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
        $show = new Show(ApplySchool::findOrFail($id));

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
        $form = new Form(new ApplySchool);
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
            ->rules('required', ['required' => '请选择状态']);
        $form->text('reason', __('拒绝原因'))->rules('nullable|string', [
            'string' => '请输入文字'
        ]);

        $form->saving(function (Form $form) {
            $this->beforeStatus = $form->model()->status;
            if ($this->beforeStatus == ApplySchoolStatusEnum::STATUS_PASS && $this->beforeStatus != $form->status) {
                $error = new MessageBag([
                    'title'   => '警告',
                    'message' => '已通过的申请单不能再更改状态',
                ]);

                return back()->with(compact('error'));
            }
        });
        $form->saved(function (Form $form) {
            if ($this->beforeStatus != $form->status && $form->status == ApplySchoolStatusEnum::STATUS_PASS) {
                DB::beginTransaction();

                try {
                    app(ApplySchoolService::class)->afterSavedHandle($form->model());
                    DB::commit();
                } catch (Exception $e) {
                    app('log')->error('更改申请单异常: ' . $e->getMessage());
                    DB::rollBack();
                }
            }
        });
        return $form;
    }
}
