<?php

declare(strict_types=1);

namespace App\Rules;

use App\Data\Bank\BankAccountType;
use App\Rules\Base\BaseEnumRule;

class BankAccountTypeRule extends BaseEnumRule
{
    const TYPE_NAME = BankAccountType::TYPE_NAME;

    public function __construct()
    {
        parent::__construct(BankAccountType::class);
    }
}
