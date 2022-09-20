<?php

declare(strict_types=1);

namespace App\Http\ViewResources\Error;

use App\Exceptions\AppErrorCode;
use App\Http\ViewResources\Base\BaseViewResource;
use Illuminate\Http\Request;

class ErrorViewResource extends BaseViewResource
{
    public ?string $title = null;

    public string $message;

    public AppErrorCode $appErrorCode;

    public int $statusCode;

    public static function make(
        Request $request,
        string $message,
        AppErrorCode $appErrorCode,
        int $statusCode
    ): self {
        $vd = new self($request);
        $vd->message = $message;
        $vd->appErrorCode = $appErrorCode;
        $vd->statusCode = $statusCode;

        return $vd;
    }

    public function getTitle(): ?string
    {
        return $this->title ?? 'エラー';
    }

    public function getDescription(): ?string
    {
        return 'エラー（説明）';
    }

    public function getKeywords(): ?array
    {
        return ['error'];
    }

}
