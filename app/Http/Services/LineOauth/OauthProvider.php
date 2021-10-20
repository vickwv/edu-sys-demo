<?php

namespace App\Http\Services\LineOauth;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

/**
 * <p>
 *  配置或处理认证逻辑，接口逻辑
 * </p>
 *
 * @author: wangwei
 * @date: 2021-10-20
 */
class OauthProvider extends AbstractProvider
{
    /**
     * Domain
     *
     * @var string
     */
    public $domain = 'https://access.line.me';

    /**
     * Api domain
     *
     * @var string
     */
    public $apiDomain = 'https://api.line.me';


    public function getBaseAuthorizationUrl()
    {
        return $this->domain . "/oauth2/v2.1/authorize";
    }

    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->apiDomain . "/oauth2/v2.1/token";
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->apiDomain . "/v2/profile";
    }

    protected function getDefaultScopes()
    {
       return "openid profile";
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() != 200) {
            throw new IdentityProviderException($response->getBody(), -1, $data);
        }
    }

    protected function getDefaultHeaders()
    {
        return ['Content-Type' => 'application/json'];
    }

    protected function getAuthorizationHeaders($token = null)
    {
        return ['Authorization' => 'Bearer ' .  $token];
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
         return new LineResourceOwner($response);
    }
}