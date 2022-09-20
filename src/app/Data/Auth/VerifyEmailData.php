<?php

declare(strict_types=1);

namespace App\Data\Auth;

use App\Data\Common\EmailAddress;
use App\Data\Data;
use Carbon\CarbonImmutable;

final class VerifyEmailData implements Data
{
    public function __construct(
        public string $token,
        public VerifyEmailGroup $group,
        public EmailAddress $email,
        public CarbonImmutable $expiration
    ) {
    }
}
