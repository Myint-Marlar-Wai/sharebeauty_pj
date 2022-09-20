<?php

declare(strict_types=1);

namespace App\Http\ViewResources\Shop\Auth;

use App\Http\Requests\Shop\Auth\Guest\LoginPerformRequest;
use App\Http\ViewResources\Base\BaseViewResource;
use Illuminate\Http\Request;

class LoginViewResource extends BaseViewResource
{
    public string $input_email;

    public string $input_password;

    public static function make(Request $request): self
    {
        $vd = new self($request);

        $vd->input_email = old(LoginPerformRequest::PARAM_EMAIL) ?? '';
        $vd->input_password = old(LoginPerformRequest::PARAM_PASSWORD) ?? '';

        return $vd;
    }

    public function getTitle(): string
    {
        return 'ログイン';
    }

}
