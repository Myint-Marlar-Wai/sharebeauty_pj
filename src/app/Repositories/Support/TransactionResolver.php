<?php

declare(strict_types=1);

namespace App\Repositories\Support;

use App\Repositories\Repository;

interface TransactionResolver
{
    /**
     * @param array|Repository[] $repositories
     * @return TransactionExecutor
     */
    public function resolve(array $repositories) : TransactionExecutor;
}
