<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop\Auth;

use App\Constants\Sessions\ShopSessions;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\Shop\Auth\VerifyEmailVerifyRequest;
use App\Http\Requests\Shop\DefaultMemberRequest;
use App\Http\Routes\ShopRoutes;
use App\Http\ViewResources\Common\DefaultViewResource;
use App\Http\ViewResources\Shop\Auth\VerifyEmailIndexViewResource;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends BaseController
{
    /**
     * Display the email verification prompt.
     *
     * @param DefaultMemberRequest $request
     * @return RedirectResponse|View
     */
    public function getPrompt(DefaultMemberRequest $request): RedirectResponse|View
    {
        $authUser = $request->getAuthUser();
        if ($authUser->hasVerifiedEmail()) {
            return redirect()->intended(ShopRoutes::urlHome());
        }

        return view('shop.auth.verify-email', [
            'vr' => VerifyEmailIndexViewResource::make($request),
        ]);
    }

    /**
     * Send a new email verification notification.
     *
     * @param  DefaultMemberRequest  $request
     * @return RedirectResponse
     */
    public function postSend(DefaultMemberRequest $request): RedirectResponse
    {
        $authUser = $request->getAuthUser();

        if ($authUser->hasVerifiedEmail()) {
            return redirect()->intended(ShopRoutes::urlHome());
        }

        $authUser->sendEmailVerificationNotification();

        return back()->with(ShopSessions::VERIFY_EMAIL_VERIFICATION_LINK_RESENT, true);
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param VerifyEmailVerifyRequest $request 認証を確認しています
     * @return RedirectResponse
     */
    public function verifyEmail(VerifyEmailVerifyRequest $request): RedirectResponse
    {
        $authUser = $request->getAuthUser();

        if ($authUser->hasVerifiedEmail()) {
            return redirect()->intended(ShopRoutes::urlHome());
        }
        $authUser->markEmailAsVerified();

        return ShopRoutes::toVerificationVerifyCompleted();
    }

    public function getVerifyCompleted(Request $request): View
    {
        return view('shop.auth.verify-email-completed', [
            'vr' => DefaultViewResource::make($request),
        ]);
    }
}
