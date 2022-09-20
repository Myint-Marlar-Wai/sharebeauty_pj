<?php

declare(strict_types=1);

namespace App\Data\Common;

use App\Data\Base\StringCodeFactory;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;

final class LoosePassword extends Password
{
    use StringCodeFactory;

    const TYPE_NAME = 'password';

    protected function validateValue(string $value): void
    {
        // 全体で使える文字
        if (! preg_match('/^[a-zA-Z0-9!#$%&=|?\-_]{1,255}$/', $value)) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_PASSWORD);
        }
    }
}
