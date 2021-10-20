<?php


namespace App\Http\Services\LineOauth;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

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

    protected function createResourceOwner(array $response, AccessToken $token)
    {
         return new LineResourceOwner($response);
    }
}