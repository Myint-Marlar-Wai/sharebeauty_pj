<?php

declare(strict_types=1);

namespace App\Providers;

use App\Constants\App\AppSystem;
use App\Constants\Routes\SellerRateLimiters;
use App\Constants\Routes\ShopRateLimiters;
use App\Data\Demo\DemoFormId;
use App\Data\Shop\DisplayShopId;
use App\Data\Shop\ShopId;
use App\Exceptions\AppExceptions;
use App\Http\Routes\DemoRoutes;
use App\Http\Routes\SellerRoutes;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot(): void
    {

        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            $appSystem = app_core()->getSystem();
            match ($appSystem) {
                AppSystem::Shop => $this->mapShopRoutes(),
                AppSystem::Seller => $this->mapSellerRoutes(),
                AppSystem::Admin => $this->mapAdminRoutes(),
                AppSystem::Batch => $this->mapBatchRoutes(),
            };

            // debug
            $this->mapDebugRoutes();

            // demo
            match ($appSystem) {
                AppSystem::Shop,
                AppSystem::Seller,
                AppSystem::Admin => $this->mapDemoRoutes(),
                default => null
            };

            $this->mapRouteBinding();
        });
    }

    protected function mapRouteBinding()
    {
        // デモフォームID
        Route::pattern(DemoRoutes::PARAM_FORM_ID, '[0-9]+');
        Route::bind(DemoRoutes::PARAM_FORM_ID, function ($value) {
            return DemoFormId::tryFromIntString(strval($value)) ??
                throw AppExceptions::badRouteParam(DemoRoutes::PARAM_FORM_ID);
        });

        // 表示用ショップID
        Route::pattern(SellerRoutes::PARAM_DISPLAY_SHOP_ID, '[a-z0-9]+');
        Route::bind(SellerRoutes::PARAM_DISPLAY_SHOP_ID, function ($value) {
            return DisplayShopId::tryFromString(strval($value)) ??
                throw AppExceptions::badRouteParam(SellerRoutes::PARAM_DISPLAY_SHOP_ID);
        });

        // ショップID
        Route::pattern(SellerRoutes::PARAM_SHOP_ID, '[0-9]+');
        Route::bind(SellerRoutes::PARAM_SHOP_ID, function ($value) {
            return ShopId::tryFromIntString(strval($value)) ??
                throw AppExceptions::badRouteParam(SellerRoutes::PARAM_SHOP_ID);
        });
    }

    /***
     * @return void
     */
    protected function mapShopRoutes(): void
    {
        Route::middleware('web-shop')
            ->namespace($this->namespace)
            ->group(base_path('routes/web-shop.php'));
    }

    /***
     * @return void
     */
    protected function mapSellerRoutes(): void
    {
        Route::middleware('web-seller')
            ->namespace($this->namespace)
            ->group(base_path('routes/web-seller.php'));
    }

    /***
     * @return void
     */
    protected function mapAdminRoutes(): void
    {
        Route::middleware('web-admin')
            ->namespace($this->namespace)
            ->group(base_path('routes/web-admin.php'));
    }

    /***
     * @return void
     */
    protected function mapBatchRoutes(): void
    {
        Route::middleware('batch')
            ->namespace($this->namespace)
            ->group(base_path('routes/batch.php'));
    }

    /***
     * @return void
     */
    protected function mapDebugRoutes(): void
    {
        Route::middleware('debug')
            ->namespace($this->namespace)
            ->group(base_path('routes/debug.php'));
    }

    /***
     * @return void
     */
    protected function mapDemoRoutes(): void
    {
        Route::middleware('demo')
            ->namespace($this->namespace)
            ->prefix('_demo')
            ->group(base_path('routes/demo.php'));
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)
                ->by(optional($request->user())->id ?: $request->ip());
        });

        $appSystem = app_core()->getSystem();
        match ($appSystem) {
            AppSystem::Shop => $this->configureRateLimitingForShop(),
            AppSystem::Seller => $this->configureRateLimitingForSeller(),
            AppSystem::Admin => $this->configureRateLimitingForAdmin(),
            AppSystem::Batch => $this->configureRateLimitingForBatch(),
        };
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimitingForShop(): void
    {
        RateLimiter::for(ShopRateLimiters::REGISTRATION, function (Request $request) {
            return Limit::perMinute(6)
                ->by($request->ip());
        });
        RateLimiter::for(ShopRateLimiters::VERIFY_EMAIL_SEND, function (Request $request) {
            return Limit::perMinute(6)
                ->by($request->ip());
        });
        RateLimiter::for(ShopRateLimiters::VERIFY_EMAIL_VERIFY, function (Request $request) {
            return Limit::perMinute(6)
                ->by($request->ip());
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimitingForSeller(): void
    {
        RateLimiter::for(SellerRateLimiters::REGISTRATION, function (Request $request) {
            return Limit::perMinute(6)
                ->by($request->ip());
        });
        RateLimiter::for(SellerRateLimiters::VERIFY_EMAIL_SEND, function (Request $request) {
            return Limit::perMinute(6)
                ->by($request->ip());
        });
        RateLimiter::for(SellerRateLimiters::VERIFY_EMAIL_VERIFY, function (Request $request) {
            return Limit::perMinute(6)
                ->by($request->ip());
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimitingForAdmin(): void
    {

    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimitingForBatch(): void
    {

    }
}
