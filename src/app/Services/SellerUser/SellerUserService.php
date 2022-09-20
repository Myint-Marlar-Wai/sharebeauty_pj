<?php

declare(strict_types=1);

namespace App\Services\SellerUser;

use App\Data\Common\EmailAddress;
use App\Data\Common\GoogleId;
use App\Data\Common\Password;
use App\Data\Common\StrictPassword;
use App\Data\SellerUser\SellerAuthData;
use App\Data\SellerUser\SellerId;
use App\Exceptions\Basic\AppMismatchCurrentPasswordException;
use App\Exceptions\Basic\AppNoPasswordOnPasswordChangeException;
use App\Exceptions\Basic\AppUserAlreadyExistsException;
use Carbon\CarbonImmutable;

interface SellerUserService extends \App\Services\Service
{
    /**
     * @param EmailAddress $email
     * @param Password $password
     * @return SellerAuthData
     * @throws AppUserAlreadyExistsException
     */
    public function registerByEmail(
        EmailAddress $email,
        Password     $password,
    ): SellerAuthData;

    /**
     * @param GoogleId $googleId
     * @param EmailAddress $email
     * @param bool $isEmailVerified
     * @return SellerAuthData
     * @throws AppUserAlreadyExistsException
     */
    public function registerByGoogle(
        GoogleId     $googleId,
        EmailAddress $email,
        bool         $isEmailVerified
    ): SellerAuthData;

    /**
     * @param SellerId $userId
     * @param Password $currentPassword
     * @param StrictPassword $newPassword
     * @throws AppMismatchCurrentPasswordException
     * @throws AppNoPasswordOnPasswordChangeException
     */
    public function changePassword(
        SellerId       $userId,
        Password       $currentPassword,
        StrictPassword $newPassword
    );

    public function completeVerifyEmail(
        SellerId        $userId
    ): SellerAuthData;
}
