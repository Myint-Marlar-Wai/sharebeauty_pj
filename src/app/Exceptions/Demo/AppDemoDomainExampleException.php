<?php

declare(strict_types=1);

namespace App\Exceptions\Demo;

use App\Exceptions\AppErrorCode;
use App\Exceptions\Basic\AppBasicException;
use Throwable;

class AppDemoDomainExampleException extends AppBasicException
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
            AppErrorCode::DemoDomainExample, [], $message, $previous);
    }
}
