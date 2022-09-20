<?php

declare(strict_types=1);

namespace App\Data\Base;

use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use InvalidArgumentException;
use LogicException;

trait StringCodeFactory
{
    /**
     * @param string $string
     * @return static
     * @throws InvalidArgumentException
     */
    public static function fromString(string $string): static
    {
        return new static(value: $string);
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
        if (is_string($var)) {
            return self::fromString($var);
        }
        throw AppExceptions::invalidArgumentException(
            AppErrorCode::INVALID_ARGUMENT_STRING_CODE);
    }

    /**
     * @param mixed $var
     * @return ?static
     */
    public static function tryFrom(mixed $var): ?static
    {
        if ($var instanceof static) {
            return clone $var;
        }
        if (is_string($var)) {
            return self::tryFromString($var);
        }
        return null;
    }

    /**
     * @param string $str
     * @return ?static
     */
    public static function tryFromString(string $str): ?static
    {
        try {
            return new static(value: $str);
        } catch (LogicException $ex) {
            return null;
        }
    }
}
