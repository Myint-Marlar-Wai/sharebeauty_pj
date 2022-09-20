<?php

declare(strict_types=1);

namespace App\Data\SellerUser;

use App\Data\Base\IntId;
use App\Data\Base\IntIdFactory;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;

final class SellerId extends IntId
{
    use IntIdFactory;

    const TYPE_NAME = 'seller_id';

    const MIN_VALUE = 1;

    protected function validateValue(int $value): void
    {
        if ($value < static::MIN_VALUE) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_SELLER_ID);
        }
    }

}
