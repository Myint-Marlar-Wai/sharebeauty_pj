<?php

declare(strict_types=1);

namespace App\Data\Support;

use App\Data\Equatable;

final class Equatables
{
    private function __construct()
    {
    }

    public static function equals(?Equatable $a, ?Equatable $b): bool
    {
        if ($a === null) {
            return $b === null;
        } else {
            return $b !== null && $a->equals($b);
        }
    }
}
