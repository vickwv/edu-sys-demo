<?php


namespace App\Http\Controllers;

use App\Http\Requests\FollowTeacherRequest;
use App\Http\Services\StudentService;
use Illuminate\Http\JsonResponse;

/**
 * 功能：学生业务逻辑
 *
 * @author: stevenv
 * @date: 2021-10-14
 **/
class StudentController extends Controller
{

    /** @var StudentService $studentService  */
    protected $studentService;

    public function __construct()
    {
        $this->studentService = app(StudentService::class);
    }

    /**
     * 功能： 关注老师
     *
     * @author: stevenv
     * @date  : 2021-10-14
     * @param FollowTeacherRequest $request
     * @return JsonResponse
     */
    public function followTeacher(FollowTeacherRequest $request) {
        $isSuccess = $this->studentService->followTeacher($request->teacher_id);
        return $this->success('success', ['isSuccess' => $isSuccess]);
    }
}