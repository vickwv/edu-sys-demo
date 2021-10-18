<?php

namespace App\Http\Controllers;

use App\Exceptions\BusinessException;
use App\Exceptions\RegisterFailException;
use App\Http\Requests\TeacherRegisterRequest;
use App\Http\Services\TeacherService;
use Illuminate\Http\JsonResponse;

/**
 * 功能：老师相关接口
 *
 * @author: stevenv
 * @date: 2021-10-12
 **/
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
     * @param TeacherRegisterRequest $request
     * @return JsonResponse
     * @throws RegisterFailException|BusinessException
     * @author: stevenv
     * @date  : 2021-10-10
     */
    public function register(TeacherRegisterRequest $request) {
        return $this->success('success', $this->teacherService->registerTeacher($request->validated()));
    }
}
