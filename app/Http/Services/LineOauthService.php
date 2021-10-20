<?php


namespace App\Http\Services;

use App\Http\Services\LineOauth\OauthProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;

/**
 * <p>
 *  Line 认证业务逻辑
 * </p>
 *
 * @author: wangwei
 * @date: 2021-10-20
 */
class LineOauthService
{
    /** @var OauthProvider $provider */
    protected $provider;

    public function __construct(string $redirectUrl) {
        $this->provider = new OauthProvider([
            'clientId'                => env('CHANNEL_ID'),    // The client ID assigned to you by the provider
            'clientSecret'            => env('CHANNEL_SECRET'),    // The client password assigned to you by the provider
            'redirectUri'             => $redirectUrl,
        ]);
    }

    public function generateLoginUrl(array $params) {
        return $this->provider->getAuthorizationUrl($params);
    }

    public function getUser(AccessToken $accessToken) {
        return $this->provider->getResourceOwner($accessToken);
    }

    public function getAccessToken(array $options = [], string $grant = 'authorization_code') {
        try {
            return $this->provider->getAccessToken($grant, $options);
        } catch (IdentityProviderException $e) {
            app('log')->error('Line获取AccessToken出错:' . $e->getMessage());
            return null;
        }
    }
}