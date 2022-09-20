<?php

declare(strict_types=1);

namespace App\Exceptions\Logic;

use App\Exceptions\AppErrorCode;
use App\Exceptions\AppException;
use App\Exceptions\AppExceptions;
use App\Exceptions\Support\AppExceptionTrait;
use InvalidArgumentException;
use Throwable;

class AppInvalidArgumentException extends InvalidArgumentException implements AppException
{
    use AppExceptionTrait;

    /**
     * @param AppErrorCode $appErrorCode
     * @param array $arguments
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct(
        AppErrorCode $appErrorCode,
        array $arguments = [],
        string $message = '',
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $appErrorCode->value, $previous);
        $this->appErrorCode = $appErrorCode;
        $this->arguments = $arguments;
    }

    public function withAttribute(?string $attribute) : static
    {
        $this->arguments[AppExceptions::ARG_ATTRIBUTE] = $attribute;

        return $this;
    }
}
