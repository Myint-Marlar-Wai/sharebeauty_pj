<?php

declare(strict_types=1);

namespace App\Http\ViewResources\Seller\Auth;

use App\Http\Requests\Seller\Auth\Guest\RegistrationPerformRequest;
use App\Http\ViewResources\Base\BaseViewResource;
use Illuminate\Http\Request;

class RegistrationViewResource extends BaseViewResource
{
    public string $input_email;

    public string $input_password;

    public static function make(Request $request): self
    {
        $vd = new self($request);

        $vd->input_email = old(RegistrationPerformRequest::PARAM_EMAIL) ?? '';
        $vd->input_password = old(RegistrationPerformRequest::PARAM_PASSWORD) ?? '';

        return $vd;
    }

    public function getTitle(): string
    {
        return 'ONCE ID 登録';
    }

}
