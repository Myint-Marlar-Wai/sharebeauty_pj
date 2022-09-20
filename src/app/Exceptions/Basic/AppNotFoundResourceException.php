<?php

declare(strict_types=1);

namespace App\Exceptions\Basic;

use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use Throwable;

class AppNotFoundResourceException extends AppBasicException
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
        parent::__construct(AppErrorCode::NotFoundResource, [
            AppExceptions::ARG_ATTRIBUTE => $attribute,
        ], $message, $previous);
    }
}
