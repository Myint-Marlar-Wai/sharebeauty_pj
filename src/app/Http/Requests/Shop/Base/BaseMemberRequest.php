<?php

declare(strict_types=1);

namespace App\Http\Requests\Shop\Base;

use App\Auth\Models\ShopAuthUser;
use App\Auth\ShopAuth;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseMemberRequest extends FormRequest
{
    public function getAuthUser() : ShopAuthUser
    {
        return ShopAuth::user();
    }

    public function getGuard(): \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
    {
        return ShopAuth::guard();
    }
}
