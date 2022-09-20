<?php

declare(strict_types=1);

namespace App\Repositories\SellerUser;

use App\Data\Common\EmailAddress;
use App\Data\Common\GoogleId;
use App\Data\Common\HashedPassword;
use App\Data\SellerUser\SellerAuthData;
use App\Data\SellerUser\SellerId;
use Carbon\CarbonImmutable;

interface SellerUserRepository
{
    public function getAuthData(
        SellerId $userId
    ): ?SellerAuthData;

    public function getIdByEmail(
        EmailAddress $email
    ): ?SellerId;

    public function getIdByGoogleId(
        GoogleId $googleId
    ): ?SellerId;

    public function lockForUserCreate();

    public function createByEmail(
        EmailAddress   $email,
        HashedPassword $hashedPassword,
    ): SellerId;

    public function createByGoogle(
        GoogleId         $googleId,
        EmailAddress     $email,
        ?CarbonImmutable $emailVerifiedAt
    ): SellerId;

    public function updatePassword(
        SellerId       $userId,
        HashedPassword $hashedPassword,
    );

    public function markEmailVerified(
        SellerId         $userId,
        ?CarbonImmutable $verifiedAt
    );

    public function markRegistrationCompleted(
        SellerId         $userId,
        ?CarbonImmutable $completedAt,
    );

    public function cleanSoftDeleteByEmail(
        EmailAddress $email
    );

    public function cleanSoftDeleteByGoogleId(
        GoogleId $googleId
    );

    public function delete(
        SellerId $userId
    );

}
