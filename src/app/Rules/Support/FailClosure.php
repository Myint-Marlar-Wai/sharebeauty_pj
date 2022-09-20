<?php

declare(strict_types=1);

namespace App\Rules\Support;

use Illuminate\Translation\PotentiallyTranslatedString;
use RuntimeException;

/**
 * IDE補完用
 */
final class FailClosure
{
    private function __construct()
    {
    }


    /**
     * @param string $attribute
     * @param ?string $message
     * @return PotentiallyTranslatedString
     */
    public function __invoke($attribute, $message = null): PotentiallyTranslatedString
    {
        throw new RuntimeException();
    }
}
