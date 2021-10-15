<?php

namespace App\Http\Controllers;

use App\Exceptions\LoginFailException;
use App\Http\Requests\LineLoginRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /** @var AuthService $authService */
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * 功能：登陆逻辑
     *
     * @author: stevenv
     * @date  : 2021-10-15
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws LoginFailException
     */
    public function login(LoginRequest $request) {
        $result = $this->authService->login($request);

        return $this->success('success', $result);
    }

    /**
     * 功能：line Callback
     *
     * @author: stevenv
     * @date  : 2021-10-14
     * @param LineLoginRequest $request
     * @return JsonResponse
     */
    public function lineCallback(LineLoginRequest $request) {
        return $this->success('success', ['is_bind' => $this->authService->lineCallback($request)]);
    }
}
