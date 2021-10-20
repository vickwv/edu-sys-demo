<?php


namespace App\Http\Controllers;

use App\Exceptions\BusinessException;
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
     * @throws BusinessException
     */
    public function followTeacher(FollowTeacherRequest $request) {
        $isFollow = $this->studentService->followTeacher($request->teacher_id, $request->is_follow);
        return $this->success('success', ['is_follow' => $isFollow]);
    }

    /**
     * 功能：获取关注的老师
     *
     * @author: stevenv
     * @date: 2021-10-15
     **/
    public function getFollowTeachers() {
        return $this->success('success', $this->studentService->getFollowTeachers());
    }
}