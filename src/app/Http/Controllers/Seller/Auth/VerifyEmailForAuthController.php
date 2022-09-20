<?php

declare(strict_types=1);

namespace App\Http\Controllers\Seller\Auth;

use App\Constants\Sessions\SellerSessions;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\Seller\Auth\VerifyEmailIndexRequest;
use App\Http\Requests\Seller\Auth\VerifyEmailSendPerformRequest;
use App\Http\Routes\SellerRoutes;
use App\Http\ViewResources\Seller\Auth\VerifyEmailIndexViewResource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class VerifyEmailForAuthController extends BaseController
{
    /**
     * Display the email verification prompt.
     *
     * @param VerifyEmailIndexRequest $request
     * @return View|RedirectResponse
     */
    public function getIndex(VerifyEmailIndexRequest $request): View|RedirectResponse
    {
        $authUser = $request->getAuthUser();
        if ($authUser->hasVerifiedEmail()) {
            // 確認済みのため、元の画面もしくはHOMEへ
            return redirect()->intended(SellerRoutes::urlHome());
        }
        return view('seller.auth.verify-email', [
            'vr' => VerifyEmailIndexViewResource::make($request),
        ]);
    }


    /**
     * Send a new email verification notification.
     *
     * @param VerifyEmailSendPerformRequest $request
     * @return RedirectResponse
     */
    public function postSendPerform(VerifyEmailSendPerformRequest $request): RedirectResponse
    {
        $authUser = $request->getAuthUser();

        if ($authUser->hasVerifiedEmail()) {
            // 確認済みのため、元の画面もしくはHOMEへ
            return redirect()->intended(SellerRoutes::urlHome());
        }
        $authUser->sendEmailVerificationNotification();

        return back()->with(SellerSessions::VERIFY_EMAIL_VERIFICATION_LINK_RESENT, true);
    }


}
