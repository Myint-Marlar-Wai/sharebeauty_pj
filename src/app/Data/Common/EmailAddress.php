<?php

declare(strict_types=1);

namespace App\Data\Common;

use App\Data\Base\StringCode;
use App\Data\Base\StringCodeFactory;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;

final class EmailAddress extends StringCode
{
    use StringCodeFactory;

    const TYPE_NAME = 'email_address';

    protected function validateValue(string $value): void
    {
        if (! filter_var($value, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE)) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_EMAIL_ADDRESS);
        }
    }
}
