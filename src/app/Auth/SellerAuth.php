<?php

declare(strict_types=1);

namespace App\Auth;

use App\Auth\Models\SellerAuthUser;
use App\Auth\UserProviders\SellerUserAuthUserProvider;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use Auth;
use Illuminate\Auth\AuthManager;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Auth\SessionGuard;
use LogicException;
use Password;

final class SellerAuth
{
    private function __construct()
    {
    }

    const GUARD_WEB = 'seller_web';
    const PASSWORD = 'pw_seller_users';

    public static function guard(): \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
    {
        return auth(self::GUARD_WEB);
    }

    public static function passwordBroker(): \Illuminate\Contracts\Auth\PasswordBroker
    {
        return Password::broker(self::PASSWORD);
    }

    public static function user(): SellerAuthUser
    {
        $guard = self::guard();
        $user = $guard->user();
        if (! ($user instanceof SellerAuthUser)) {
            throw AppExceptions::logicException(AppErrorCode::LOGIC_EXCEPTION_ILLEGAL_AUTH_USER_MODEL);
        }

        return $user;
    }

    public static function getUserProvider(): SellerUserAuthUserProvider
    {
        $guard = self::guard();
        if (! ($guard instanceof SessionGuard)) {
            throw AppExceptions::logicException(AppErrorCode::LOGIC_EXCEPTION_GENERAL);
        }
        $provider = $guard->getProvider();
        if (! ($provider instanceof SellerUserAuthUserProvider)) {
            throw AppExceptions::logicException(AppErrorCode::LOGIC_EXCEPTION_GENERAL);
        }
        return $provider;
    }

}
