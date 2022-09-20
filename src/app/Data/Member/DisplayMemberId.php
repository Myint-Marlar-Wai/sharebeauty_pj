<?php

declare(strict_types=1);

namespace App\Data\Member;

use App\Data\Base\IntId;
use App\Data\Base\IntIdFactory;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use InvalidArgumentException;

/**
 * 表示用ショップ会員(買い手)ID
 */
final class DisplayMemberId extends IntId
{
    use IntIdFactory;

    const TYPE_NAME = 'display_member_id';

    const INCREMENT_START = 1234;

    const MIN_VALUE = self::INCREMENT_START * 10;

    // 10億
    const MAX_VALUE = 1000000000;

    const FIXED_PART_INT = 2;

    protected function validateValue(int $value): void
    {
        if (($value % 10) !== self::FIXED_PART_INT) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_DISPLAY_MEMBER_ID_FIXED_DIGITS);
        }
        if ($value < self::MIN_VALUE) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_DISPLAY_MEMBER_ID_MIN_VALUE);
        }
        if ($value > self::MAX_VALUE) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_DISPLAY_MEMBER_ID);
        }
    }

    public function getIncrementInt() :  int
    {
        return intval(floor($this->value / 10)) - self::INCREMENT_START;
    }

    /**
     * @param int $incrementInt 0から
     * @return static
     * @throws InvalidArgumentException
     */
    public static function makeWithIncr(int $incrementInt): static
    {
        if ($incrementInt < 0) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_DISPLAY_MEMBER_ID);
        }
        return new static((($incrementInt + self::INCREMENT_START) * 10) + self::FIXED_PART_INT);
    }


}
