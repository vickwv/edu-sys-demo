<?php

namespace App\Admin\Controllers;

use App\Model\School;
use App\Model\Student;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class StudentController extends AdminController
{

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '学生管理';

    protected function getSchoolMap()
    {
        $schools = School::select('id', 'name')->get();
        $schoolMap = [];
        if ($schools->isNotEmpty()) {
            $schoolMap = $schools->mapWithKeys(function ($item) {
                return [$item['id'] => $item['name']];
            });
        }

        return ! empty($schoolMap) ? $schoolMap->toArray() : [];
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $schoolMap = $this->getSchoolMap();
        $grid = new Grid(new Student);
        $grid->column('id', __('学生Id'));
        $grid->column('school_id', __('学校'))->using($schoolMap);
        $grid->column('email', __('邮箱'));
        $grid->column('name', __('名称'));
        $grid->column('line_id', __('LineID'));
        $grid->column('sex', __('性别'))->using([1 => '男', 2 => '女']);
        $grid->column('age', __('年龄'));
        $grid->column('status', __('状态'))->using([1 => '正常', 0 => '禁用']);
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
        $show = new Show(Student::findOrFail($id));
        $schoolMap = $this->getSchoolMap();
        $show->field('id', __('学生Id'));
        $show->field('school_id', __('学校'))->using($schoolMap);
        $show->field('email', __('邮箱'));
        $show->field('name', __('名称'));
        $show->field('line_id', __('Line'));
        $show->field('sex', __('性别'))->using([1 => '男', 2 => '女']);
        $show->field('age', __('年龄'));
        $show->field('status', __('状态'))->using([1 => '正常', 0 => '禁用']);
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
        $form = new Form(new Student);
        $form->select('school_id', __('学校'))->options($this->getSchoolMap())->rules('required', [
            'required' => '请选择学校',
        ]);
        $form->email('email', __('邮箱'))->rules('required|email', [
            'required' => '请填写邮箱',
            'email'    => '邮箱格式错误',
        ]);
        $form->text('name', __('名称'))->rules('required|string', [
            'required' => '请填写名称',
        ]);
        $form->password('password', __('密码'))->rules('required|string|min:8', [
            'required' => '请填写密码',
            'min'      => '密码至少8位',
        ]);
        $form->radio('sex', __('性别'))->options([1 => '男', 2 => '女'])->default(0)->rules('required|in:1,2', [
            'required' => '请选择性别',
        ]);

        $form->radio('status', __('状态'))->options([1 => '正常', 0 => '禁用'])->default(0)->rules('required|in:1,0', [
            'required' => '请选择状态',
        ]);
        $form->number('age', __('年龄'))->default(0);

        $form->saving(function (Form $form) {
            $form->password = bcrypt($form->password);
        });

        return $form;
    }
}
