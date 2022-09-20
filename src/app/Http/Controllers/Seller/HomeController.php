<?php

declare(strict_types=1);

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Base\BaseController;
use App\Http\Routes\SellerRoutes;
use Illuminate\Support\Facades\Log;

class HomeController extends BaseController
{
    public function getIndex(): \Illuminate\Http\RedirectResponse
    {
        Log::debug('HomeController.getIndex');

        return SellerRoutes::toShops();
    }
}
