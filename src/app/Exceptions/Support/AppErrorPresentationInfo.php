<?php

declare(strict_types=1);

namespace App\Exceptions\Support;

use App\Exceptions\AppErrorCode;

class AppErrorPresentationInfo
{
    public int $status;

    public ?int $resourceStatus;

    public string $message;

    public AppErrorCode $appCode;

    public array $headers;

    public bool $isHttpException;

    public bool $isUnknownException;
}
