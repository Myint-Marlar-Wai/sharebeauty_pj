<?php

declare(strict_types=1);

namespace App\Data\Member;

use App\Data\Common\EmailAddress;
use App\Data\Common\HashedPassword;
use App\Data\Data;
use Carbon\CarbonImmutable;

final class MemberAuthData implements Data
{
    public function __construct(
        public MemberId $id,
        public EmailAddress $email,
        public ?CarbonImmutable $emailVerifiedAt,
        public ?HashedPassword $hashedPassword,
        public ?CarbonImmutable $purchasedAt,
        public ?CarbonImmutable $registrationCompletedAt
    ) {
    }
}
