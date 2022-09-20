<?php

declare(strict_types=1);

namespace App\Data\Base;

use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use App\Support\Num;
use InvalidArgumentException;
use LogicException;

trait IntIdFactory
{
    /**
     * @param string $str
     * @return ?int
     */
    final protected static function parseStringToInt(string $str): ?int
    {
        return Num::parseUnsignedInt($str);
    }

    /**
     * @param int $int
     * @return static
     * @throws InvalidArgumentException
     */
    public static function fromInt(int $int): static
    {
        return new static(value: $int);
    }

    /**
     * @param string $intStr
     * @return static
     */
    public static function fromIntString(string $intStr): static
    {
        $int = self::parseStringToInt($intStr);
        if ($int === null) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_INT_ID);
        }

        return new static(value: $int);
    }

    /**
     * @param mixed $var
     * @return ?static
     */
    public static function fromNullable(mixed $var): ?static
    {
        if ($var === null) {
            return null;
        }

        return static::from($var);
    }

    /**
     * @param mixed $var
     * @return static
     */
    public static function from(mixed $var): static
    {
        if ($var instanceof static) {
            return clone $var;
        }
        if (is_int($var)) {
            return self::fromInt($var);
        }
        if (is_string($var)) {
            return self::fromIntString($var);
        }
        throw AppExceptions::invalidArgumentException(
            AppErrorCode::INVALID_ARGUMENT_INT_ID);
    }

    /**
     * @param string $intStr
     * @return ?self
     */
    public static function tryFromIntString(string $intStr): ?static
    {
        $int = self::parseStringToInt($intStr);
        if ($int === null) {
            return null;
        }

        try {
            return new static(value: $int);
        } catch (LogicException $ex) {
            return null;
        }
    }
}
