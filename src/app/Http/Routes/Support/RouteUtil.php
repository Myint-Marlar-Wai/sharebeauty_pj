<?php

declare(strict_types=1);

namespace App\Http\Routes\Support;

use App\Http\Controllers\Common\FallbackController;
use Route;

final class RouteUtil
{
    private function __construct()
    {
    }

    public static function fallbackEndpoint(): void
    {
        Route::fallback([FallbackController::class, 'notFound']);
    }
    public static function fallbackPage(): void
    {
        Route::fallback([FallbackController::class, 'notFound']);
    }

}
