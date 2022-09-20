<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;

class EnvTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_env(): void
    {
        $this->assertTrue(config('app.testing') === true);
    }
}
