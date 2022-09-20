<?php

declare(strict_types=1);

namespace App\Exceptions\Runtime;

use App\Exceptions\AppErrorCode;
use Throwable;

class AppNotFoundPageException extends AppRuntimeException
{
    /**
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message = '',
        ?Throwable $previous = null
    ) {
        parent::__construct(
            AppErrorCode::NotFoundPage, [], $message, $previous);
    }
}