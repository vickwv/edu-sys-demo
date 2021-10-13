<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('edu/teacher', TeacherController::class);
    $router->resource('edu/student', StudentController::class);
    $router->resource('edu/school', SchoolController::class);
    $router->resource('edu/apply_school', ApplySchoolController::class);
});
