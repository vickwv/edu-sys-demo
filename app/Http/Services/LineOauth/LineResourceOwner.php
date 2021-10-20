<?php


namespace App\Http\Services\LineOauth;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class LineResourceOwner implements ResourceOwnerInterface
{
    protected $response;

    public function __construct(array $response = array()) {
        $this->response = $response;
    }

    public function getId() {
        return $this->response['userId'];
    }

    public function getDisplayName() {
        return $this->response['displayName'];
    }

    public function getPictureUrl() {
        return $this->response['pictureUrl'];
    }

    public function toArray() {
        return $this->response;
    }
}