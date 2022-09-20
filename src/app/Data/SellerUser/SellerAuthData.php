<?php

declare(strict_types=1);

namespace App\Data\SellerUser;

use App\Data\Common\EmailAddress;
use App\Data\Common\GoogleId;
use App\Data\Common\HashedPassword;
use App\Data\Data;
use Carbon\CarbonImmutable;

final class SellerAuthData implements Data
{
    public function __construct(
        public SellerId $id,
        public EmailAddress $email,
        public ?CarbonImmutable $emailVerifiedAt,
        public ?HashedPassword $hashedPassword,
        public ?GoogleId $googleId,
        public ?CarbonImmutable $migratedAt,
        public ?CarbonImmutable $registrationCompletedAt
    ) {
    }
}
