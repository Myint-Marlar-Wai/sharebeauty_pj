<?php

namespace App\Repositories\Support;

use Closure;
use Throwable;

interface TransactionExecutor
{

    /**
     * Execute a Closure within a transaction.
     *
     * @param  Closure  $callback
     * @param  int  $attempts
     * @return mixed
     *
     */
    public function transaction(Closure $callback, int $attempts = 1): mixed;

}
