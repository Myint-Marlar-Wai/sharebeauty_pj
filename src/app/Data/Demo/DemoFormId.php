<?php

declare(strict_types=1);

namespace App\Data\Demo;

use App\Data\Base\IntId;
use App\Data\Base\IntIdFactory;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use InvalidArgumentException;

final class DemoFormId extends IntId
{
    use IntIdFactory;

    const TYPE_NAME = 'demo_form_id';

    const MIN_VALUE = 100;

    protected function validateValue(int $value): void
    {
        if ($value < static::MIN_VALUE) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_DEMO_FORM_ID);
        }
    }

}
