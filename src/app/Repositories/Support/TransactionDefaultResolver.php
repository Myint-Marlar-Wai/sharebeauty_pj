<?php

declare(strict_types=1);

namespace App\Repositories\Support;

class TransactionDefaultResolver implements TransactionResolver
{
    public function resolve(array $repositories): TransactionExecutor
    {
        $names = [];
        foreach ($repositories as $repository) {
            foreach ($repository->getConnectionNames() as $name) {
                if (! in_array($name, $names, true)) {
                    $names[] = $name;
                }
            }
        }

        return new TransactionDefaultExecutor($names);
    }
}
