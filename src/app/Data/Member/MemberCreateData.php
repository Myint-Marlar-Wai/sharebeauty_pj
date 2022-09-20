<?php

declare(strict_types=1);

namespace App\Data\Member;

use App\Data\Common\Gender;
use App\Data\Data;
use Carbon\CarbonImmutable;


final class MemberCreateData implements Data
{
    public function __construct(
        public string $firstName,
        public string $firstNameKana,
        public string $lastName,
        public string $lastNameKana,
        public string $zip, // todo
        public string $prefCode, // todo
        public string $address,
        public string $addressOther,
        public string $tel, // todo
        public ?Gender $gender,
        public ?CarbonImmutable $birthday, // todo
    ) {
    }
}
