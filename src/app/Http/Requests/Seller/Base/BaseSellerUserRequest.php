<?php

declare(strict_types=1);

namespace App\Http\Requests\Seller\Base;

use App\Auth\Models\SellerAuthUser;
use App\Auth\SellerAuth;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseSellerUserRequest extends FormRequest
{
    public function getAuthUser() : SellerAuthUser
    {
        return SellerAuth::user();
    }

    public function getGuard(): \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
    {
        return SellerAuth::guard();
    }
}
