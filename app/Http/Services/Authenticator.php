<?php

namespace App\Http\Services;

use App\Exceptions\BusinessException;
use App\Http\Constants\GlobalEnum;
use Illuminate\Hashing\BcryptHasher;
use RuntimeException;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Authenticator
{
    /**
     * The hasher implementation.
     *
     * @var \Illuminate\Hashing\BcryptHasher
     */
    protected $hasher;

    /**
     * Create a new repository instance.
     *
     * @param  \Illuminate\Hashing\BcryptHasher  $hasher
     * @return void
     */
    public function __construct(BcryptHasher $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $provider
     * @return Authenticatable|null
     */
    public function attempt(
        string $username,
        string $password,
        string $provider
    ): ?Authenticatable {
        if (! $model = config('auth.providers.'.$provider.'.model')) {
            throw new RuntimeException('Unable to found authentication model from configuration');
        }

        /** @var Authenticatable $user */
        if (! $user = (new $model)->where('email', $username)->first()) {
            return null;
        }

        if (! $this->hasher->check($password, $user->getAuthPassword())) {
            return null;
        }

        if ($user->status == GlobalEnum::NO) {
            throw new BusinessException("账户已经被禁用");
        }

        return $user;
    }
}
