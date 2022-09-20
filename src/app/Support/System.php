<?php

declare(strict_types=1);

namespace App\Support;

use InvalidArgumentException;

final class System
{
    private function __construct()
    {
    }

    private const NANO_SEC = 1_000_000_000;

    public static function sleepUntil(float $targetTime, float $minSleep = 0.0): void
    {
        if ($minSleep < 0.0) {
            throw new InvalidArgumentException();
        }
        $nowTime = microtime(true);

        $sleepDuration = $targetTime - $nowTime;
        if ($sleepDuration < $minSleep) {
            $sleepDuration = $minSleep;
        }
        $sleepDurationSec = (int) floor($sleepDuration);
        $sleepDurationNano = (int) floor(($sleepDuration - $sleepDurationSec) * self::NANO_SEC);
        \Log::debug('sleep', ['sec' => $sleepDurationSec, 'nano' => $sleepDurationNano, 'sec_float' => $sleepDuration]);
        time_nanosleep($sleepDurationSec, $sleepDurationNano);
    }
}
