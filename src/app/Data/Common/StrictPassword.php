<?php

declare(strict_types=1);

namespace App\Data\Common;

use App\Data\Base\StringCodeFactory;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;

/**
 * 半角英数、大文字小文字、記号（!#$%&=-|?）
 * 半角英字大文字、半角英字小文字、数字、記号の4種類が必ず混在
 * 10文字～
 */
final class StrictPassword extends Password
{
    use StringCodeFactory;

    const TYPE_NAME = 'password';

    protected function validateValue(string $value): void
    {
        // 全体で使える文字
        if (! preg_match('/^[a-zA-Z0-9!#$%&=|?\-]{10,32}$/', $value)) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_PASSWORD);
        }
        // 小文字英字が含まれるか
        if (! preg_match('/[a-z]/', $value)) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_PASSWORD_LOWERCASE_LETTERS);
        }
        // 大文字英字が含まれるか
        if (! preg_match('/[A-Z]/', $value)) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_PASSWORD_UPPERCASE_LETTERS);
        }
        // 数字が含まれるか
        if (! preg_match('/[0-9]/', $value)) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_PASSWORD_NUMBERS);
        }
        // 記号が含まれるか
        if (! preg_match('/[!#$%&=|?\-]/', $value)) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_PASSWORD_SYMBOLS);
        }
    }

}
