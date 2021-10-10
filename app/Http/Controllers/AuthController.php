<?php

namespace App\Http\Controllers;

use App\Exceptions\LoginFailException;
use App\Http\Requests\LoginRequest;
use App\Http\Model\Authenticator;

class AuthController extends Controller
{

    /**
     * @var Authenticator
     */
    private $authenticator;

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function login(LoginRequest $request) {
        $credentials = array_values($request->only('email', 'password', 'provider'));

        if (! $user = $this->authenticator->attempt(...$credentials)) {
            throw new LoginFailException();
        }

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return $this->success('success', [
            'token_type' => 'Bearer',
            'access_token' => $token,
        ]);
    }
}
