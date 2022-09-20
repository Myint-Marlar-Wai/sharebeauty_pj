<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Constants\App\AppSystem;
use App\Http\Routes\SellerRoutes;
use App\Http\Routes\ShopRoutes;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request): ?string
    {
        $appSystem = app_core()->getSystem();
        if (! $request->expectsJson()) {
            if ($appSystem === AppSystem::Seller) {
                return SellerRoutes::urlLogin();
            } elseif ($appSystem === AppSystem::Shop) {
                return ShopRoutes::urlLogin();
            }
        }

        return null;
    }
}
