<?php


namespace App\Http\Controllers;

use App\Exceptions\BusinessException;
use App\Http\Requests\AcceptInviteRequest;
use App\Http\Requests\InviteTeacherRequest;
use App\Http\Services\TeacherInviteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * <p>
 *  邀请老师接口
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
     * @throws BusinessException
     * @author: wangwei
     * @date: 2021-10-12
     */
    public function invite(InviteTeacherRequest $request) {
        $result = $this->service->invite(Auth::id(), $request->email);
        return $this->success("success", ["invite_url" => $result]);
    }

    /**
     * <p>
     *  接受邀请
     * </p>
     *
     * @param AcceptInviteRequest $request
     * @return JsonResponse
     * @throws BusinessException
     * @author: wangwei
     * @date: 2021-10-15
     */
    public function accept(AcceptInviteRequest $request) {
        $result = $this->service->accept($request->token);

        return $this->success("success", $result);
    }
}