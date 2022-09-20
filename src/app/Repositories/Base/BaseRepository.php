<?php

declare(strict_types=1);

namespace App\Repositories\Base;

use App\Repositories\Repository;

abstract class BaseRepository implements Repository
{

    public function getConnectionNames(): array
    {
        return [null];
    }
}
