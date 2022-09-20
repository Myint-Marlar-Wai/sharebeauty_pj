<?php

declare(strict_types=1);

namespace App\Support;

use InvalidArgumentException;

final class Num
{
    private function __construct()
    {
    }

    /**
     * @param string|null $str
     * @return int
     */
    public static function unsignedInt(?string $str): int
    {
        $int = self::parseUnsignedInt($str);
        if ($int === null) {
            throw new InvalidArgumentException('Can not parse unsigned int');
        }

        return $int;
    }

    /**
     * @param string|null $str
     * @return ?int
     */
    public static function parseUnsignedInt(?string $str): ?int
    {
        if (! self::canParseUnsignedInt($str)) {
            return null;
        }

        return intval($str);
    }

    /**
     * @param string|null $str
     * @return bool
     */
    public static function canParseUnsignedInt(?string $str): bool
    {
        if ($str === null) {
            return false;
        }
        if (! preg_match('/(?:^0$)|(?:^[1-9][0-9]*$)/', $str)) {
            return false;
        }

        return true;
    }
}
