<?php

declare(strict_types=1);

namespace App\Repositories;

interface Repository
{
    /**
     * @return array|string[]
     */
    public function getConnectionNames() : array;
}
