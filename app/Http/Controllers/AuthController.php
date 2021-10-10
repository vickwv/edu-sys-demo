<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request) {
        $credentials = array_values($request->only('email', 'password', 'provider'));
        $result = $this->authService->login($credentials);

        return $this->success('success', $result);
    }
}
