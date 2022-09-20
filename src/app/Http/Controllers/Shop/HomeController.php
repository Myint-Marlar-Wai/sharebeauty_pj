<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Base\BaseController;
use App\Http\Routes\SellerRoutes;
use App\Http\Routes\ShopRoutes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class HomeController extends BaseController
{
    public function getIndex(): RedirectResponse|View
    {
        Log::debug('HomeController.getIndex');

        return view('shop.dummy');
        //return ShopRoutes::toShops();
    }
}
