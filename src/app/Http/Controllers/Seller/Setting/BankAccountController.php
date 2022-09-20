<?php

namespace App\Http\Controllers\Seller\Setting;

use App\Auth\SellerAuth;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\AccountRequest;
use App\Models\Account;
use App\Models\Seller;
use App\Services\AccountService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BankAccountController extends BaseController
{
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index()
    {
        $authUser = SellerAuth::user();
        $once = Seller::find($authUser->getUserId()->getInt());
        return view('auth.account', compact($once));
    }

    public function store(AccountRequest $request)
    {
        $authUser = SellerAuth::user();
        $once = Seller::find($authUser->getUserId()->getInt());
        $account = new Account();
        DB::beginTransaction();
        try {
            $this->accountService->editAccount($once, $account, $request);
            DB::commit();
            return redirect('/setting/bank');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return redirect('/');
        }
    }
}
