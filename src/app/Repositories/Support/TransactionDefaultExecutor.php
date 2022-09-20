<?php

declare(strict_types=1);

namespace App\Repositories\Support;

use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use Closure;
use DB;
use LogicException;
use Throwable;

class TransactionDefaultExecutor implements TransactionExecutor
{
    protected array $connectionNames;

    /**
     * @param array $connectionNames
     */
    public function __construct(array $connectionNames)
    {
        $this->connectionNames = $connectionNames;
    }

    /**
     * Execute a Closure within a transaction.
     *
     * @param  Closure  $callback
     * @param  int  $attempts
     * @return mixed
     *
     * @throws Throwable
     */
    public function transaction(Closure $callback, int $attempts = 1): mixed
    {
        if (empty($this->connectionNames)) {
            throw AppExceptions::logicException(AppErrorCode::LOGIC_EXCEPTION_GENERAL);
        }
        $wrapCallback = $callback;
        foreach ($this->connectionNames as $connectionName) {
            $wrapCallback = function () use ($wrapCallback, $connectionName, $attempts) {
                return DB::connection($connectionName)->transaction($wrapCallback, $attempts);
            };
        }

        return $wrapCallback();
    }
}
