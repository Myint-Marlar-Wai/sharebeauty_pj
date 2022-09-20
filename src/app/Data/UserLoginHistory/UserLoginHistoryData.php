<?php

declare(strict_types=1);

namespace App\Data\UserLoginHistory;

use App\Data\Common\EmailAddress;
use App\Data\Data;
use Carbon\CarbonImmutable;

final class UserLoginHistoryData implements Data
{
    public function __construct(
        public CarbonImmutable $attemptAt,
        public bool $isSuccess,
        public EmailAddress $email,
        public ?string $ipAddress,
        public ?string $userAgent,
    ) {
    }
}
