<?php

declare(strict_types=1);

namespace App\Http\ViewResources\Seller\Auth;

use App\Http\Requests\Seller\Auth\Guest\PasswordResetSendLinkRequest;
use App\Http\ViewResources\Base\BaseViewResource;
use Illuminate\Http\Request;

class PasswordResetViewResource extends BaseViewResource
{
    public string $input_email;

    public static function make(Request $request): self
    {
        $vd = new self($request);

        $vd->input_email = old(PasswordResetSendLinkRequest::PARAM_EMAIL) ?? '';

        return $vd;
    }

    public function getTitle(): string
    {
        return 'パスワードリセット';
    }


}
