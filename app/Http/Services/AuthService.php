<?php


namespace App\Http\Services;

use App\Exceptions\LoginFailException;
use App\Http\Requests\LineLoginRequest;
use App\Http\Requests\LoginRequest;
use Exception;
use TyperEJ\LineLogin\Login;

/**
 * <p>
 *  用户认证
 * </p>
 *
 * @author: wangwei
 * @date: 2021-10-15
 */
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

    public function login(LoginRequest $request) {
        $credentials = array_values($request->only('email', 'password', 'provider'));

        if (! $user = $this->authenticator->attempt(...$credentials)) {
            throw new LoginFailException();
        }

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $login = new Login(env('CHANNEL_ID'));

        $redirectUrl = $this->getLineCallback([
            'id' => $user->id,
            'provider' => $request->provider
        ]);
        return [
            'access_token' => 'Bearer ' . $token,
            'lineLoginUrl' => $login->generateLoginUrl([
                'redirect_uri' => $redirectUrl,
                'state' => str_random(9),
            ]),
        ];
    }

    protected function getLineCallback(array $params) {
        return url("api/line/callback") . '?' . http_build_query($params);
    }

    /**
     * 功能：line回调
     *
     * @param LineLoginRequest $request
     * @return bool
     * @author: stevenv
     * @date  : 2021-10-14
     */
    public function lineCallback(LineLoginRequest $request) {
        $login = new Login(env('CHANNEL_ID'), env("CHANNEL_SECRET"));
        try {
            $user = $login->requestToken($request->input('code'), $this->getLineCallback([
                'id'       => $request->id,
                'provider' => $request->provider
            ]));
            $userId = $user->getProfile()->userId;
            if (! empty($userId)) {
                $model = config('auth.providers.'.$request->provider.'.model');
                (new $model)->where('id', $request->id)->update([
                    'line_id' => $userId,
                ]);

                return true;
            }
            return false;
        } catch (Exception $e) {
            app('log')->error("line 回调失败: " . $e->getMessage());
            return false;
        }
    }
}