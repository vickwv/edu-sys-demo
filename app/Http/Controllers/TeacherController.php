<?php

namespace App\Http\Controllers;


use App\Exceptions\RegisterFailException;
use App\Http\Requests\RegisterRequest;
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
     * @param RegisterRequest $request
     * @throws RegisterFailException
     */
    public function register(RegisterRequest $request) {
        $request->validate();
        return $this->success('success', $this->teacherService->register($request->validated()));
    }
}
