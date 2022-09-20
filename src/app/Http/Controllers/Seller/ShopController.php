<?php

declare(strict_types=1);

namespace App\Http\Controllers\Seller;

use App\Auth\SellerAuth;
use App\Data\Shop\DisplayShopId;
use App\Data\Shop\ShopId;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\ShopRequest;
use App\Http\Routes\SellerRoutes;
use App\Models\Shop;
use App\Services\ShopService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShopController extends BaseController
{
    private $shopService;

    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    public function getShops()
    {
        $once = SellerAuth::user();
        $shops = Shop::where('display_flag', '=', 1)
        ->where('delete_flag', '=', 0)
        ->get();

        return view('seller.shop-list', compact('shops', 'once'));
    }

    public function create()
    {
        $once = SellerAuth::user();

        return view('shop.shop-create', compact('once'));
    }

    public function store(ShopRequest $request)
    {
        $user = SellerAuth::user();
        $shop = new Shop();
        DB::beginTransaction();
        try {
            $shop = $this->shopService->shopCreate($user, $shop, $request);
            DB::commit();

            return redirect("/shop/detail/$shop->id");
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return redirect('/');
        }
    }

    public function getDetail(ShopId $id)
    {
        $once = SellerAuth::user();
        $shop = Shop::where('id', '=', $id->getIntString())->first();
        if (is_null($shop)) {
            dd('404エラー画面に遷移');

            return redirect('/');
        }
        if ($once->id !== $shop->once_id) {
            $message = 'ご指定のショップの情報閲覧権限はありません';

            return view('shop.shop-create', compact('message'));
        }

        return view('shop.shop-detail', compact('shop', 'once'));
    }

    public function publish($id)
    {
        $once = SellerAuth::user();
        $shop = Shop::where('id', '=', $id)->first();
        if (is_null($shop)) {
            dd('404エラー画面に遷移');

            return redirect('/');
        }
        if ($once->id !== $shop->once_id) {
            $message = 'ご指定のショップの公開設定はできません';

            return view('shop.top', compact('message', 'once'));
        }

        return view('shop.publishing-settings', compact('shop', 'once'));
    }

    public function publishSetting(Request $request, $id)
    {
        $user = SellerAuth::user();
        $shop = Shop::where('id', '=', $id)->first();
        $pattern = $request->input('pattern');
        DB::beginTransaction();
        try {
            $this->shopService->shopPublish($user, $shop, $pattern);
            DB::commit();

            return redirect("/shop/publish/$shop->id");
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return redirect('/');
        }
    }

    public function shopChange($shop_id)
    {
        $once = SellerAuth::user();
        $shop = Shop::where('once_id', '=', $once->id)
        ->where('id', '=', $shop_id)
        ->where('display_flag', '=', 1)
        ->first();

        return view('shop.shop-info-change', compact('once', 'shop', 'once'));
    }

    public function shopChangeStore(ShopRequest $request, $shop_id)
    {
        $once = SellerAuth::user();
        $shop = Shop::where('once_id', '=', $once->id)
        ->where('id', '=', $shop_id)
        ->where('display_flag', '=', 1)
        ->first();
        DB::beginTransaction();
        try {
            $shop = $this->shopService->shopCreate($once, $shop, $request);
            DB::commit();

            return redirect("/shop/detail/$shop->id");
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return redirect('/');
        }
    }
}
