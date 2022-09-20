<?php

declare(strict_types=1);

namespace App\Data\Demo;

use App\Data\Bank\BankAccountType;
use App\Data\Bank\BankCode;
use App\Data\Data;

final class DemoFormAlphaData implements Data
{
    public function __construct(
        public DemoFormId $id,
        public ?BankCode $bankCode,
        public ?BankAccountType $bankAccountType,
    ) {
    }


    public static function makeWithId(DemoFormId $id): self
    {
        return new self(
            id: $id,
            bankCode: null,
            bankAccountType: null
        );
    }
}
