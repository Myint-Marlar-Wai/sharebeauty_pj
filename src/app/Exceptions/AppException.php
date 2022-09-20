<?php

declare(strict_types=1);

namespace App\Exceptions;
use App\Exceptions\Support\AppErrorResolvedInfo;
use Throwable;

interface AppException extends Throwable
{
    public function getAppErrorCode(): AppErrorCode;
    public function getArguments(): array;
    public function resolveInfo(): AppErrorResolvedInfo;
    public function applyMessage(): void;


}
