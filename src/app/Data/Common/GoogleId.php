<?php

declare(strict_types=1);

namespace App\Data\Common;

use App\Data\Base\StringCode;
use App\Data\Base\StringCodeFactory;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use InvalidArgumentException;

final class GoogleId extends StringCode
{
    use StringCodeFactory;

    const TYPE_NAME = 'google_id';

    protected function validateValue(string $value): void
    {
        if (! preg_match('/^[0-9a-zA-Z]{1,255}$/', $value)) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_GOOGLE_ID);
        }
    }
}
