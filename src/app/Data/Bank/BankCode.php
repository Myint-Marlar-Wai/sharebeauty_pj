<?php

declare(strict_types=1);

namespace App\Data\Bank;

use App\Data\Base\StringCode;
use App\Data\Base\StringCodeFactory;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use InvalidArgumentException;

final class BankCode extends StringCode
{
    use StringCodeFactory;

    const TYPE_NAME = 'bank_code';

    protected function validateValue(string $value): void
    {
        if (! preg_match('/^[0-9]{4}$/', $value)) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_BANK_CODE);
        }
    }
}
