<?php

declare(strict_types=1);

namespace App\Exceptions\Basic;

use App\Exceptions\AppErrorCode;
use Throwable;

class AppMismatchCurrentPasswordException extends AppBasicException
{
    /**
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message = '',
        ?Throwable $previous = null
    ) {
        parent::__construct(AppErrorCode::MismatchCurrentPassword, [], $message, $previous);
    }
}
