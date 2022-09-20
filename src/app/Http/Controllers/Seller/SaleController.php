<?php

namespace App\Http\Controllers\Seller;

use App\Auth\SellerAuth;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\EditProfileRequest;
use App\Models\SellerProfile;
use App\Models\Shop;
use App\Services\SaleService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaleController extends BaseController
{
    private $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function index($once_id)
    {
        $once = SellerAuth::user();
        $shops = Shop::where('once_id', '=', $once['id'])
        ->where('display_flag', '=', 1)
        ->where('delete_flag', '=', 0)
        ->get();
        return view('shop.shop-sale', compact('once', 'shops'));
    }

    public function shopIndex($shop_id)
    {
        $once = SellerAuth::user();
        $shops = Shop::where('once_id', '=', $once['id'])
        ->where('display_flag', '=', 1)
        ->where('delete_flag', '=', 0)
        ->get();

        return view('shop.shop-sale-individual', compact('once', 'shops'));
    }

    public function store(EditProfileRequest $request)
    {
        $once = SellerAuth::user();
        $profile = new SellerProfile();
        DB::beginTransaction();
        try {
            $this->profileService->editProfile($once, $profile, $request);
            DB::commit();
            return redirect('/profile');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return redirect('/');
        }
    }
}
