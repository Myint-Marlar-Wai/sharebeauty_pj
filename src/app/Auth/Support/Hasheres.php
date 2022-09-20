<?php

declare(strict_types=1);

namespace App\Auth\Support;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

final class Hasheres
{
    private function __construct()
    {
    }

    public static function getHasher(): HasherContract
    {
        return app()->make(HasherContract::class);
    }
}
