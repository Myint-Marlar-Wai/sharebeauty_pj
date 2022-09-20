<?php

declare(strict_types=1);

namespace App\Exceptions\Support;

use App\Components\Error\AppExceptionInfoResolver;
use App\Exceptions\AppErrorCode;

trait AppExceptionTrait
{
    protected AppErrorCode $appErrorCode;

    protected array $arguments;

    protected ?AppErrorResolvedInfo $resolvedInfo = null;

    public function getAppErrorCode(): AppErrorCode
    {
        return $this->appErrorCode;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function applyMessage(): void
    {
        if ($this->message === '') {
            $this->message = $this->resolveInfo()->message;
        }
    }

    protected function getInfoResolver(): AppExceptionInfoResolver
    {
        return app(AppExceptionInfoResolver::class);
    }

    public function resolveInfo(): AppErrorResolvedInfo
    {
        if ($this->resolvedInfo === null) {
            $this->resolvedInfo = $this->getInfoResolver()->resolve(
                $this->getAppErrorCode(),
                $this->getArguments()
            );
        }
        return $this->resolvedInfo;
    }
}
