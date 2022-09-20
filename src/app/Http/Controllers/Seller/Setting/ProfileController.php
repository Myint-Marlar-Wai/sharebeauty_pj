<?php

namespace App\Http\Controllers\Seller\Setting;

use App\Auth\SellerAuth;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\EditProfileRequest;
use App\Models\SellerProfile;
use App\Services\ProfileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileController extends BaseController
{
    private $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        $once = SellerAuth::user();
        return view('auth.profile', compact('once'));
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
