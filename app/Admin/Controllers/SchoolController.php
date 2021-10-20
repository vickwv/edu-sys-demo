<?php

namespace App\Admin\Controllers;

use App\Model\School;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SchoolController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '学校管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new School);

        $grid->column('id', __('Id'));
        $grid->column('name', __('名称'));
        $grid->column('province', __('省份'));
        $grid->column('city', __('城市'));
        $grid->column('area', __('地区'));
        $grid->column('address', __('地址'));
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
        $show = new Show(School::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('名称'));
        $show->field('province', __('省份'));
        $show->field('city', __('城市'));
        $show->field('area', __('地区'));
        $show->field('address', __('地址'));
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
        $form = new Form(new School);
        $form->text('name', __('名称'))->rules('required|string|max:20', [
            'max' => '最大20个字',
            'required' => '不能为空',
        ]);
        $form->text('province', __('省份'))->rules('required|string|max:16', [
            'max' => '最大16个字',
            'required' => '不能为空',
        ]);
        $form->text('city', __('城市'))->rules('required|string|max:16', [
            'max' => '最大16个字',
            'required' => '不能为空',
        ]);
        $form->text('area', __('地区'))->rules('required|string|max:16', [
            'max' => '最大16个字',
            'required' => '不能为空',
        ]);
        $form->text('address', __('地址'))->rules('required|string|max:32', [
            'max' => '最大32个字',
            'required' => '不能为空',
        ]);

        return $form;
    }
}
