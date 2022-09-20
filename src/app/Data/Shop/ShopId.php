<?php

declare(strict_types=1);

namespace App\Data\Shop;

use App\Data\Base\IntId;
use App\Data\Base\IntIdFactory;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use InvalidArgumentException;

final class ShopId extends IntId
{
    use IntIdFactory;

    const TYPE_NAME = 'shop_id';

    protected function validateValue(int $value): void
    {
        if ($value < 1) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_SHOP_ID);
        }
    }

}
