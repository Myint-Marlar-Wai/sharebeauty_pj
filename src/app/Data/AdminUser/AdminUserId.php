<?php

declare(strict_types=1);

namespace App\Data\AdminUser;

use App\Data\Base\IntId;
use App\Data\Base\IntIdFactory;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;

final class AdminUserId extends IntId
{
    use IntIdFactory;

    const TYPE_NAME = 'admin_user_id';

    const MIN_VALUE = 1;

    /**
     * システムユーザ
     */
    const VALUE_SYSTEM = 1;

    protected function validateValue(int $value): void
    {
        if ($value < static::MIN_VALUE) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_ADMIN_USER_ID);
        }
    }

    /**
     * システムユーザ
     * @return static
     */
    public static function ofSystem() : self
    {
        return self::fromInt(self::VALUE_SYSTEM);
    }
}
