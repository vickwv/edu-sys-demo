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
Route::post('signup', 'TeacherController@register');
Route::post('login', 'AuthController@login');
Route::get('teacher_invite/accept', 'TeacherInviteController@accept'); // 接受邀请
Route::get('line/callback', 'AuthController@callback');

Route::middleware('auth:teacher')->group(function () {
   Route::post('apply_school/create', 'ApplySchoolController@create');
   Route::group(['prefix' => 'teacher_invite'], function() {
        Route::get('invite', 'TeacherInviteController@invite'); // 邀请老师
   });
});

Route::middleware('auth:student')->group(function () {
    Route::post('student/follow', 'StudentController@followTeacher');
    Route::post('student/follow_teacher/list', 'StudentController@getFollowTeachers');
});