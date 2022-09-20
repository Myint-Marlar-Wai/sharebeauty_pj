<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Components\Route\RouteDetector;
use Closure;
use Illuminate\Http\Request;

class ApiBehavior
{
    protected RouteDetector $routeDetector;

    /**
     * @param RouteDetector $apiDetector
     */
    public function __construct(RouteDetector $apiDetector)
    {
        $this->routeDetector = $apiDetector;
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
        \Log::debug('ApiBehavior.handle');
        return $next($request);
    }
}
