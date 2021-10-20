<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('teacher/signup', 'TeacherController@register'); // 注册
Route::post('login', 'AuthController@login'); // 登陆
Route::get('teacher_invite/accept', 'TeacherInviteController@accept'); // 接受邀请
Route::get('line/callback', 'AuthController@lineCallback'); // line回调

Route::middleware('auth:teacher')->group(function () {
   Route::post('apply_school/create', 'ApplySchoolController@create'); // 创建申请单
    Route::get('teacher_invite/invite', 'TeacherInviteController@invite'); // 邀请老师
});

Route::middleware('auth:student')->group(function () {
    Route::post('student/follow', 'StudentController@followTeacher'); // 关注老师
    Route::get('student/follow_teacher/all', 'StudentController@getFollowTeachers'); // 获取关注的老师
});