<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Runner\AfterLastTestHook;
use PHPUnit\Runner\BeforeFirstTestHook;

class Extension implements BeforeFirstTestHook, AfterLastTestHook
{
    use CreatesApplication;

    public function executeAfterLastTest(): void
    {
        // 最後のテストの実行後にコールされます
        echo "\n\n== executeAfterLastTest\n\n";
    }

    /**
     * @throws \RuntimeException
     */
    public function executeBeforeFirstTest(): void
    {
        // 最初のテストの実行前にコールされます
        echo "\n\n== executeBeforeFirstTest\n\n";

        $app = $this->createApplication();
        try {
            echo 'APP_ENV = '.env('APP_ENV').PHP_EOL;
            echo 'app.name = '.config('app.name').PHP_EOL;
            echo 'app.env = '.config('app.env').PHP_EOL;
            echo 'app.system = '.config('app.system').PHP_EOL;
            echo 'app.data_env = '.config('app.data_env').PHP_EOL;
            echo 'app.testing = '.json_encode(config('app.testing')).PHP_EOL;
            if (config('app.testing') !== true) {
                throw new \RuntimeException('Not testing');
            }
        } finally {
            $app->flush();
            $app = null;
        }
    }
}
