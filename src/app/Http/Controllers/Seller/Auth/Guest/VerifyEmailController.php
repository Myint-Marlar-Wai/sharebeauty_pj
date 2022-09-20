<?php

declare(strict_types=1);

namespace App\Http\Controllers\Seller\Auth\Guest;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\Seller\Auth\Guest\VerifyEmailIndexForGuestRequest;
use App\Http\Requests\Seller\Auth\Guest\VerifyEmailVerifyLinkRequest;
use App\Http\Requests\Seller\Auth\Guest\VerifyEmailVerifyPerformRequest;
use App\Http\Routes\SellerRoutes;
use App\Http\ViewResources\Common\DefaultViewResource;
use App\Http\ViewResources\Seller\Auth\VerifyEmailIndexViewResource;
use App\Http\ViewResources\Seller\Auth\VerifyEmailLinkViewResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends BaseController
{
    /**
     * Display the email verification prompt.
     *
     * @param VerifyEmailIndexForGuestRequest $request
     * @return RedirectResponse|View
     */
    public function getIndexForGuest(VerifyEmailIndexForGuestRequest $request): RedirectResponse|View
    {
        return view('seller.auth.verify-email', [
            'vr' => VerifyEmailIndexViewResource::make($request),
        ]);
    }


    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param VerifyEmailVerifyLinkRequest $request
     * @return View
     */
    public function getVerifyLink(VerifyEmailVerifyLinkRequest $request): View
    {
        return view('seller.auth.verify-email-link', [
            'vr' => VerifyEmailLinkViewResource::make($request),
        ]);
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param VerifyEmailVerifyPerformRequest $request 認証を確認しています
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function postVerifyPerform(VerifyEmailVerifyPerformRequest $request): RedirectResponse
    {
        $authUser = $request->getTargetAuthUserOrError();

        if (! $authUser->hasVerifiedEmail()) {
            $authUser->markEmailAsVerified();
        }

        return SellerRoutes::toVerificationVerifyCompleted();
    }

    public function getVerifyCompleted(Request $request): View
    {
        return view('seller.auth.verify-email-completed', [
            'vr' => DefaultViewResource::make($request),
        ]);
    }
}
