<?php

declare(strict_types=1);

namespace App\Auth\UserProviders;

use App\Auth\Models\ShopAuthUser;
use App\Auth\Models\ShopDefaultAuthUser;
use App\Data\Common\EmailAddress;
use App\Data\Common\Password;
use App\Data\Common\StrictPassword;
use App\Data\Member\MemberAuthData;
use App\Data\Member\MemberId;
use App\Repositories\Member\MemberRepository;
use BadMethodCallException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Log;

class ShopUserAuthUserProvider implements UserProvider
{
    const PROVIDER_NAME = 'shop_user_auth';

    protected MemberRepository $userRepository;

    /**
     * @param MemberRepository $userRepository
     */
    public function __construct(MemberRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function retrieveById($identifier): ?ShopAuthUser
    {
        $id = MemberId::from($identifier);
        $userData = $this->userRepository->getAuthData($id);
        if ($userData === null) {
            return null;
        }

        return $this->makeAuthUserFromUserData($userData);
    }

    protected function makeAuthUserFromUserData(MemberAuthData $userData): ShopAuthUser
    {
        return new ShopDefaultAuthUser(
            userId: $userData->id,
            email: $userData->email,
            emailVerifiedAt: $userData->emailVerifiedAt,
            hashedPassword: $userData->hashedPassword,
            purchasedAt: $userData->purchasedAt,
            registrationCompletedAt: $userData->registrationCompletedAt,
            rememberToken: null,
            userData: $userData,
        );
    }

    public function retrieveByToken($identifier, $token): ?Authenticatable
    {
        Log::debug('retrieveByToken', ['identifier' => $identifier]);
        throw new BadMethodCallException();
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        Log::debug('updateRememberToken');
        throw new BadMethodCallException();
    }

    public function retrieveByCredentials(array $credentials): ShopAuthUser|Authenticatable|null
    {
        Log::debug('retrieveByCredentials', ['credentials' => $credentials]);
        if (isset($credentials['email'])) {
            $email = EmailAddress::from($credentials['email']);
            $userId = $this->userRepository->getIdByEmail($email);
            $userData = $userId !== null ? $this->userRepository->getAuthData($userId) : null;
            if ($userData === null) {
                return null;
            }

            return $this->makeAuthUserFromUserData($userData);
        }

        return null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        Log::debug('validateCredentials', ['credentials' => $credentials]);
        if (! ($user instanceof ShopAuthUser)) {
            return false;
        }
        if (isset($credentials['password'])) {
            $plain = $credentials['password'];
            if (! ($plain instanceof Password)) {
                $plain = StrictPassword::fromString($credentials['password']);
            }
            $hashed = $user->getHashedPassword();
            if ($hashed === null) {
                return false;
            }
            if (! $user->canPasswordLogin()) {
                return false;
            }

            return $hashed->matchWithPlain($plain);
        }

        return false;
    }

}
