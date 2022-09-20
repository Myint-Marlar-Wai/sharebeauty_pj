<?php

declare(strict_types=1);

namespace App\Auth\UserProviders;

use BadMethodCallException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Log;

class EmptyAuthUserProvider implements UserProvider
{
    const PROVIDER_NAME = 'empty_auth';

    /**
     * The hasher implementation.
     *
     * @var \Illuminate\Contracts\Hashing\Hasher
     */
    protected $hasher;

    /**
     * @param HasherContract $hasher
     */
    public function __construct(HasherContract $hasher)
    {
        $this->hasher = $hasher;
    }

    public function retrieveById($identifier): ?Authenticatable
    {
        return null;
    }

    public function retrieveByToken($identifier, $token): ?Authenticatable
    {
        throw new BadMethodCallException();
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        throw new BadMethodCallException();
    }

    public function retrieveByCredentials(array $credentials): Authenticatable|null
    {
        return null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return false;
    }

}
