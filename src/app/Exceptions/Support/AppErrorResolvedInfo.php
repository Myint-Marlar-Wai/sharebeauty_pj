<?php

namespace App\Exceptions\Support;

class AppErrorResolvedInfo
{
    public string $message;
    public int $status;
    public ?int $resourceStatus;
}
