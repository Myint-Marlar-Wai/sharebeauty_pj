<?php
namespace App\Http\Controllers\Seller\Setting;

use App\Auth\SellerAuth;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\OnceRequest;
use App\Services\OnceService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OnceController extends BaseController
{
    private $onceService;

    public function __construct(OnceService $onceService)
    {
        $this->onceService = $onceService;
    }

    public function setting()
    {
        $once = SellerAuth::user();
        return view('onceid.setting', compact('once'));
    }

    public function index()
    {
        $once = SellerAuth::user();
        if(isset($once->google_id)) {
            dd('エラー画面遷移');
        }
        return view('account.once', compact('once'));
    }

    public function store(OnceRequest $request)
    {
        $once = SellerAuth::user();
        $email = $request->input('email');
        DB::beginTransaction();
        try {
            $this->onceService->editAccount($once, $email);
            DB::commit();
            return redirect('/setting/complete');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return redirect('/setting/once');
        }
    }

    public function complete()
    {
        $once = SellerAuth::user();
        if(isset($once->google_id)) {
            dd('エラー画面遷移');
        }
        return view('onceid.change-accept-completed', compact('once'));
    }
}
