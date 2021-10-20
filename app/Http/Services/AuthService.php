<?php


namespace App\Http\Services;

use App\Exceptions\LoginFailException;
use App\Http\Requests\LineLoginRequest;
use App\Http\Requests\LoginRequest;
use Exception;

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
        $redirectUrl = $this->generateLineCallback([
            'id' => $user->id,
            'provider' => $request->provider
        ]);
        $lineOauthService = new LineOauthService($redirectUrl);

        return [
            'access_token' => 'Bearer ' . $token,
            'lineLoginUrl' => $lineOauthService->generateLoginUrl([
                'state' => str_random(9),
            ]),
        ];
    }

    protected function generateLineCallback(array $params) {
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
        $redirectUrl = $this->generateLineCallback([
            'id'       => $request->id,
            'provider' => $request->provider
        ]);
        $lineOauthService = new LineOauthService($redirectUrl);
        try {
            $token = $lineOauthService->getAccessToken(['code' => $request->code]);
            if (! empty($token)) {
                $user = $lineOauthService->getUser($token);
                $userId = $user->getId();
                if (! empty($userId)) {
                    $model = config('auth.providers.'.$request->provider.'.model');
                    (new $model)->where('id', $request->id)->update([
                        'line_id' => $userId,
                    ]);

                    return true;
                }
            }

            return false;
        } catch (Exception $e) {
            app('log')->error("line 回调失败: " . $e->getMessage());
            return false;
        }
    }
}