<?php

declare(strict_types=1);

namespace App\Data;

interface Equatable
{
    public function equals(mixed $other) : bool;
}
