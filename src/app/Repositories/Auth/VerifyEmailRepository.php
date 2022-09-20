<?php

declare(strict_types=1);

namespace App\Repositories\Auth;

use App\Data\Auth\VerifyEmailData;
use App\Data\Auth\VerifyEmailGroup;
use App\Data\Common\EmailAddress;
use Carbon\CarbonImmutable;

interface VerifyEmailRepository
{
    public function deleteVerifyEmail(
        VerifyEmailGroup $group,
        string $token
    );

    public function createVerifyEmail(
        VerifyEmailGroup $group,
        EmailAddress $email,
        CarbonImmutable $expiration
    ): VerifyEmailData;

    public function updateVerifyEmail(
        VerifyEmailData $data
    );

    public function getVerifyEmailByToken(
        VerifyEmailGroup $group,
        string $token
    ): ?VerifyEmailData;
}
