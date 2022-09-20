<?php

declare(strict_types=1);

namespace App\Auth\UserProviders;

use App\Auth\Models\SellerAuthUser;
use App\Auth\Models\SellerDefaultAuthUser;
use App\Data\Common\EmailAddress;
use App\Data\Common\GoogleId;
use App\Data\Common\Password;
use App\Data\Common\StrictPassword;
use App\Data\SellerUser\SellerAuthData;
use App\Data\SellerUser\SellerId;
use App\Data\Support\Equatables;
use App\Repositories\SellerUser\SellerUserRepository;
use BadMethodCallException;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Log;

class SellerUserAuthUserProvider implements UserProvider
{
    const PROVIDER_NAME = 'seller_user_auth';

    protected SellerUserRepository $userRepository;

    /**
     * @param SellerUserRepository $userRepository
     */
    public function __construct(SellerUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function retrieveById($identifier): ?SellerAuthUser
    {
        $id = SellerId::from($identifier);
        $userData = $this->userRepository->getAuthData($id);
        if ($userData === null) {
            return null;
        }

        return $this->makeAuthUserFromUserData($userData);
    }

    protected function makeAuthUserFromUserData(SellerAuthData $userData): SellerAuthUser
    {
        return new SellerDefaultAuthUser(
            userId: $userData->id,
            email: $userData->email,
            emailVerifiedAt: $userData->emailVerifiedAt,
            hashedPassword: $userData->hashedPassword,
            googleId: $userData->googleId,
            migratedAt: $userData->migratedAt,
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

    public function retrieveByCredentials(array $credentials): SellerAuthUser|Authenticatable|null
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
        } elseif (isset($credentials['google_user'])) {
            $googleUser = $credentials['google_user'];
            // Laravel\Socialite\Contracts\User|\Laravel\Socialite\Two\User
            if (! ($googleUser instanceof \Laravel\Socialite\Two\User)) {
                return null;
            }
            $googleId = GoogleId::fromString($googleUser->getId());
            $userId = $this->userRepository->getIdByGoogleId($googleId);
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
        if (! ($user instanceof SellerAuthUser)) {
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
        if (isset($credentials['google_user'])) {
            $googleUser = $credentials['google_user'];
            // Laravel\Socialite\Contracts\User|\Laravel\Socialite\Two\User
            if (! ($googleUser instanceof \Laravel\Socialite\Two\User)) {
                return false;
            }

            return Equatables::equals(
                GoogleId::fromString($googleUser->getId()),
                $user->getGoogleId()
            );
        }

        return false;
    }

}
