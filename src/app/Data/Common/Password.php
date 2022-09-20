<?php

declare(strict_types=1);

namespace App\Data\Common;

use App\Auth\SellerAuth;
use App\Data\Base\StringCode;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

abstract class Password extends StringCode
{
    const TYPE_NAME = 'password';

    public function makeHashed() : HashedPassword
    {
        return HashedPassword::fromPlain($this);
    }

}
