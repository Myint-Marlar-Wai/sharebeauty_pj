<?php

declare(strict_types=1);

namespace App\Data\Shop;

use App\Data\Base\StringCode;
use App\Data\Base\StringCodeFactory;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;

/**
 * ショップ登録時に入力
 * 半角英数小文字のみ、先頭文字について制約はなし
 * 3～20文字
 */
final class DisplayShopId extends StringCode
{
    use StringCodeFactory;

    const TYPE_NAME = 'display_shop_id';

    protected function validateValue(string $value): void
    {
        if ($value === '') {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_DISPLAY_SHOP_ID);
        }
        if (! preg_match('/^[a-z0-9]{3,20}$/', $value)) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_DISPLAY_SHOP_ID);
        }
    }
}
