<?php

declare(strict_types=1);

namespace App\Http\Controllers\Seller\Setting;

use App\Auth\SellerAuth;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\PasswordResetSendRequest;
use App\Services\PasswordService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

/**
 * @deprecated legacy
 */
class LegacyPasswordController extends BaseController
{
    public function __construct(
        protected PasswordService $passwordService,
    ) {
    }

    public function index()
    {
        return view('auth.forgot-password');
    }

    public function emailSend(PasswordResetSendRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? redirect('/forgot-password/send')
            : back()->withErrors(['email' => __($status)]);
    }

    public function create(Request $request)
    {
        $once = SellerAuth::user();
        $token = $request->input('token');

        return view('auth.reset-password', compact('token', 'once'));
    }

    public function reset(PasswordResetRequest $request)
    {
        $token = $request->input('token');
        $email = $request->input('email');
        $password = $request->input('password');
        DB::beginTransaction();
        try {
            $this->passwordService->resetPassword($token, $email, $password);
            DB::commit();

            return redirect('/reset/password/compleate');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();

            return redirect()->back();
        }
    }

    public function send()
    {
        $once = SellerAuth::user();

        return view('onceid.password-reset-send', compact('once'));
    }

    public function complete()
    {
        $once = SellerAuth::user();

        return view('onceid.password-accept-completed', compact('once'));
    }
}
