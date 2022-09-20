<?php

declare(strict_types=1);

namespace App\Exceptions\Runtime;

use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use Throwable;

class AppBadParameterException extends AppRuntimeException
{
    /**
     * @param string|null $attribute
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct(
        ?string $attribute = null,
        string $message = '',
        ?Throwable $previous = null
    ) {
        parent::__construct(AppErrorCode::BadRequestParameter, [
            AppExceptions::ARG_ATTRIBUTE => $attribute,
        ], $message, $previous);
    }
}
