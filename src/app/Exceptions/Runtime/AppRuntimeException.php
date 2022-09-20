<?php

declare(strict_types=1);

namespace App\Exceptions\Runtime;

use App\Exceptions\AppErrorCode;
use App\Exceptions\AppException;
use App\Exceptions\Support\AppExceptionTrait;
use Illuminate\Support\Arr;
use RuntimeException;
use Throwable;

class AppRuntimeException extends RuntimeException implements AppException
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
        $this->arguments = Arr::whereNotNull($arguments);
    }

}
