<?php


namespace App\Http\Services;

use App\Exceptions\LoginFailException;
use App\Http\Services\Authenticator;

class AuthService
{
    /**
     * @var Authenticator
     */
    private $authenticator;

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function login(array $credentials) {
        if (! $user = $this->authenticator->attempt(...$credentials)) {
            throw new LoginFailException();
        }

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return [
            'access_token' => 'Bearer ' . $token,
        ];
    }
}