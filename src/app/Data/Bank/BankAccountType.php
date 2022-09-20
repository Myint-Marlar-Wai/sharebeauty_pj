<?php

declare(strict_types=1);

namespace App\Data\Bank;

use App\Data\Base\GetLangTextInterface;
use App\Data\Base\GetLangTextTrait;

enum BankAccountType: string implements GetLangTextInterface
{
    use GetLangTextTrait;

    const TYPE_NAME = 'bank_account_type';

    /**
     * 普通預金口座
     */
    case Savings = 'savings';

    /**
     * 当座預金口座
     */
    case Current = 'current';
}
