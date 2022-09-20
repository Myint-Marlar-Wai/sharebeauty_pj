<?php

declare(strict_types=1);

namespace App\Http\ViewResources\Shop\Auth;

use App\Http\Requests\Shop\Auth\Guest\PasswordResetUpdatePerformRequest;
use App\Http\ViewResources\Base\BaseViewResource;
use Illuminate\Http\Request;

class PasswordUpdateViewResource extends BaseViewResource
{
    public string $hidden_token;
    public string $input_email;
    public string $input_new_password;

    public static function make(Request $request): self
    {
        $vd = new self($request);

        $vd->hidden_token = $request->route('token');
        $vd->input_email = old(PasswordResetUpdatePerformRequest::PARAM_EMAIL, $request->input('email')) ?? '';
        $vd->input_new_password = old(PasswordResetUpdatePerformRequest::PARAM_NEW_PASSWORD, null) ?? '';

        return $vd;
    }

    public function getTitle(): string
    {
        return 'パスワード設定';
    }
}
