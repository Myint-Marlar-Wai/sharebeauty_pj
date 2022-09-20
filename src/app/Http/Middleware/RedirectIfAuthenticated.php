<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Constants\App\AppSystem;
use App\Http\Routes\SellerRoutes;
use App\Http\Routes\ShopRoutes;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
    /**
     * The authentication factory instance.
     *
     * @var Auth
     */
    protected Auth $auth;

    /**
     * Create a new middleware instance.
     *
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @param string|null ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }
        $appSystem = app_core()->getSystem();
        \Log::debug('guest', ['guards' => $guards]);
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                if ($appSystem === AppSystem::Seller) {
                    return SellerRoutes::toHome();
                } elseif ($appSystem === AppSystem::Shop) {
                    return ShopRoutes::toHome();
                }
            }
        }

        return $next($request);
    }
}
