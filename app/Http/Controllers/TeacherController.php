<?php

namespace App\Http\Controllers;


use App\Exceptions\RegisterFailException;
use App\Http\Requests\TeacherRegisterRequest;
use App\Http\Services\TeacherService;


class TeacherController extends Controller
{

    /**
     * @var TeacherService $teacherService;
     */
    protected $teacherService;

    public function __construct(TeacherService $teacherService) {
        $this->teacherService = $teacherService;
    }

    /**
     * 功能：注册
     *
     * @author: stevenv
     * @date  : 2021-10-10
     * @param TeacherRegisterRequest $request
     * @throws RegisterFailException
     */
    public function register(TeacherRegisterRequest $request) {
        $request->validate();
        return $this->success('success', $this->teacherService->register($request->validated()));
    }
}
