<?php

declare(strict_types=1);

namespace App\Http\ViewResources\Seller\Auth;

use App\Http\ViewResources\Base\BaseViewResource;
use Illuminate\Http\Request;

class PasswordChangeViewResource extends BaseViewResource
{

    public string $input_current_password;

    public string $input_new_password;

    public static function make(Request $request): self
    {
        $vd = new self($request);

        $vd->input_current_password = '';
        $vd->input_new_password = '';

        return $vd;
    }

    public function getTitle(): string
    {
        return 'パスワード変更';
    }

}
