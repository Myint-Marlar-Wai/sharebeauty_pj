<?php

declare(strict_types=1);

namespace App\Data\Base;

use App\Data\Equatable;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use InvalidArgumentException;
use JsonSerializable;
use LogicException;

abstract class StringCode implements Equatable, JsonSerializable
{
    /**
     * @var string
     */
    protected readonly string $value;

    /**
     * @param string $value
     * @throws InvalidArgumentException
     */
    protected function __construct(string $value)
    {
        $this->validateValue($value);
        $this->value = $value;
    }

    /**
     * @param string $value
     * @return void
     * @throws InvalidArgumentException
     */
    abstract protected function validateValue(string $value): void;

    /**
     * @return string
     */
    public function getString(): string
    {
        return $this->value;
    }

    public function equals($other): bool
    {
        // important static
        if (! ($other instanceof static)) {
            return false;
        }

        return $this->value === $other->value;
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }

}
