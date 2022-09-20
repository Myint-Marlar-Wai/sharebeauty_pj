<?php

declare(strict_types=1);

namespace App\Auth\Guards;

use App\Auth\Models\SellerAuthUser;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use LogicException;

class SellerGuard extends SessionGuard
{
    public function user() : SellerAuthUser
    {
        $user = parent::user();
        if (! ($user instanceof SellerAuthUser)) {
            throw AppExceptions::logicException(AppErrorCode::LOGIC_EXCEPTION_ILLEGAL_AUTH_USER_MODEL);
        }
        return $user;
    }
}
