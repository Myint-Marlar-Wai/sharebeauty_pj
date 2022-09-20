<?php

declare(strict_types=1);

namespace App\Components\Route;

use App\Constants\Middleware\MiddlewareNames;
use Illuminate\Http\Request;

class RouteDetector
{
    public function isApiRequest(Request $request): bool
    {
//        \Log::debug('ApiDetector', [
//            'computedMiddleware' => $request->route()?->computedMiddleware,
//            'controllerMiddleware' => $request->route()?->controllerMiddleware(),
//            'gatherMiddleware' => $request->route()?->gatherMiddleware(),
//            'excludedMiddleware' => $request->route()?->excludedMiddleware(),
//        ]);
        $middleware = $request->route()?->gatherMiddleware() ?? [];

        return in_array(MiddlewareNames::API_BEHAVIOR, $middleware);
    }
}
