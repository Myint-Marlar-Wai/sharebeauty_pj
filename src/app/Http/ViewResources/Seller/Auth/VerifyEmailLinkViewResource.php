<?php

declare(strict_types=1);

namespace App\Http\ViewResources\Seller\Auth;

use App\Http\Requests\Seller\Auth\Guest\PasswordResetUpdatePerformRequest;
use App\Http\Requests\Seller\Auth\Guest\VerifyEmailVerifyPerformRequest;
use App\Http\Requests\Seller\Auth\Guest\VerifyEmailVerifyLinkRequest;
use App\Http\ViewResources\Base\BaseViewResource;
use Illuminate\Http\Request;

class VerifyEmailLinkViewResource extends BaseViewResource
{
    public string $hidden_token;
    public string $input_email;

    public static function make(VerifyEmailVerifyLinkRequest $request): self
    {
        $vd = new self($request);

        $vd->hidden_token = $request->getRouteToken();
        $vd->input_email = old(VerifyEmailVerifyPerformRequest::PARAM_EMAIL,
            $request->getInputEmail()->getString()) ?? '';

        return $vd;
    }

    public function getTitle(): string
    {
        return 'メールアドレスの確認';
    }
}
