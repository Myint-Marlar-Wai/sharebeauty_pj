<?php

declare(strict_types=1);

namespace App\Data\Member;

use App\Data\Base\IntId;
use App\Data\Base\IntIdFactory;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use InvalidArgumentException;

/**
 * ショップ会員(買い手)内部ID
 */
final class MemberId extends IntId
{
    use IntIdFactory;

    const TYPE_NAME = 'member_id';

    protected function validateValue(int $value): void
    {
        if ($value < 1) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_MEMBER_ID);
        }
    }

}
