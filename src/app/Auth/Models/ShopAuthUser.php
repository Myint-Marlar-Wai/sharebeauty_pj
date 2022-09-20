<?php

declare(strict_types=1);

namespace App\Auth\Models;

use App\Data\Common\EmailAddress;
use App\Data\Common\HashedPassword;
use App\Data\Common\Password;
use App\Data\Member\MemberId;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;

interface ShopAuthUser extends \Illuminate\Contracts\Auth\Authenticatable, MustVerifyEmailContract, HasEmailAuthUser, HasPrimaryKeyAuthUser
{
    public function getUserId() : MemberId;

    public function getEmailAddress() : ?EmailAddress;

    public function getHashedPassword(): ?HashedPassword;

    public function hasPassword() : bool;

    public function forceUpdatePassword(Password $password);

    public function isPurchasedUser() : bool;

    public function canPasswordLogin() :  bool;

}
