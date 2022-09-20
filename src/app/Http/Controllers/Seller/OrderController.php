<?php
namespace App\Http\Controllers\Seller;

use App\Auth\SellerAuth;
use App\Http\Controllers\Base\BaseController;
use App\Models\Shop;
use App\Services\OnceService;
use Illuminate\Support\Facades\Auth;
use View;

class OrderController extends BaseController
{
    private $onceService;

    public function __construct(OnceService $onceService)
    {
        $this->onceService = $onceService;
    }

    public function index($shop_id)
    {
        $once = SellerAuth::user();
        $shop = Shop::where('id', '=', $shop_id)->first();
        View::share("shopView", true);
        return view('shop.order-list', compact('once', 'shop'));
    }
}
