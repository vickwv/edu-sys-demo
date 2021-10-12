<?php


namespace App\Http\Controllers;

use App\Http\Requests\InviteTeacherRequest;
use App\Http\Services\TeacherInviteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * <p>
 *  邀请老师 controller
 * </p>
 *
 * @author: wangwei
 * @date: 2021-10-12
 */
class TeacherInviteController extends Controller
{
    /** @var TeacherInviteService $service */
    protected $service;
    public function __construct() {
        $this->service = app(TeacherInviteService::class);
    }

    /**
     * <p>
     *  邀请老师
     * </p>
     *
     * @param InviteTeacherRequest $request
     * @return JsonResponse
     * @author: wangwei
     * @date: 2021-10-12
     */
    public function invite(InviteTeacherRequest $request) {
        return $this->success("success", ["url" => $this->service->invite(Auth::id(), $request->email)]);
    }
}