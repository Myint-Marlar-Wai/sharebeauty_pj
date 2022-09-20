<?php

declare(strict_types=1);

namespace App\Components\App;

use Illuminate\Contracts\Foundation\Application;

class DefaultHashKey implements HashKey
{
    protected string $key;

    public function __construct(
        protected Application $app
    ) {
        $key = $this->app['config']['app.key'];

        if (str_starts_with($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }
        $this->key = $key;
    }

    public function getValue(): string
    {
        return $this->key;
    }
}
