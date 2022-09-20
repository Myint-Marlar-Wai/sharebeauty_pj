<?php

declare(strict_types=1);

namespace App\Data\Base;

use App\Data\Equatable;
use App\Data\Value;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use App\Support\Num;
use InvalidArgumentException;
use JsonSerializable;
use LogicException;

abstract class IntId implements Equatable, JsonSerializable, Value
{
    /**
     * @var int
     */
    protected readonly int $value;

    /**
     * @param int $value
     * @throws InvalidArgumentException
     */
    protected function __construct(int $value)
    {
        $this->validateValue($value);
        $this->value = $value;
    }

    /**
     * @param int $value
     * @return void
     * @throws InvalidArgumentException
     */
    abstract protected function validateValue(int $value): void;

    /**
     * @return int
     */
    public function getInt(): int
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getIntString(): string
    {
        return strval($this->value);
    }

    public function equals(mixed $other): bool
    {
        // important static
        if (! ($other instanceof static)) {
            return false;
        }

        return $this->value === $other->value;
    }

    public function jsonSerialize(): int
    {
        return $this->value;
    }

}
