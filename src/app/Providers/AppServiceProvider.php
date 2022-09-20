<?php

declare(strict_types=1);

namespace App\Providers;

use App\Components\App\AppCore;
use App\Components\App\DefaultAppCore;
use App\Components\App\DefaultHashKey;
use App\Components\App\HashKey;
use App\Repositories\RepositoryBootstrap;
use App\Services\ServiceBootstrap;
use Blade;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(
            AppCore::class,
            DefaultAppCore::class
        );
        $this->app->singleton(
            HashKey::class,
            DefaultHashKey::class
        );

        RepositoryBootstrap::register($this->app);
        ServiceBootstrap::register($this->app);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
        if (app_core()->isDebug()) {
            $this->enableQueryLog();
        }
    }

    private function enableQueryLog()
    {
        DB::enableQueryLog();
        DB::listen(function (QueryExecuted $query) {
            Log::debug('SQL', [
                'runtime' => $query->time,
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'session' => session()->getId(),
            ]);

            DB::flushQueryLog();
        });
    }
}
