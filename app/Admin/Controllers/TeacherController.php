<?php

namespace App\Admin\Controllers;

use App\Model\TeacherModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TeacherController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\TeacherModel';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TeacherModel);

        $grid->column('id', __('Id'));
        $grid->column('email', __('Email'));
        $grid->column('name', __('Name'));
        $grid->column('role', __('Role'));
        $grid->column('password', __('Password'));
        $grid->column('sex', __('Sex'));
        $grid->column('age', __('Age'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(TeacherModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('email', __('Email'));
        $show->field('name', __('Name'));
        $show->field('role', __('Role'));
        $show->field('password', __('Password'));
        $show->field('sex', __('Sex'));
        $show->field('age', __('Age'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TeacherModel);

        $form->email('email', __('Email'));
        $form->text('name', __('Name'));
        $form->switch('role', __('Role'))->default(3);
        $form->password('password', __('Password'));
        $form->switch('sex', __('Sex'));
        $form->number('age', __('Age'));

        return $form;
    }
}
