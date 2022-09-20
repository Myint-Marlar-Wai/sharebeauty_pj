<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop\Auth\Guest;

use App\Auth\ShopAuth;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\Shop\Auth\Guest\LoginPerformRequest;
use App\Http\Routes\ShopRoutes;
use App\Http\ViewResources\Shop\Auth\LoginViewResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends BaseController
{
    /**
     * @param Request $request
     * @return View
     */
    public function getIndex(Request $request): View
    {
        return view('shop.auth.login', [
            'vr' => LoginViewResource::make($request),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginPerformRequest $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function postLoginPerform(LoginPerformRequest $request): RedirectResponse
    {
        $request->attemptAuthenticate();

        return redirect()->intended(ShopRoutes::urlHome());
    }

    /**
     * Destroy an authenticated session.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function postLogoutPerform(Request $request): RedirectResponse
    {
        ShopAuth::guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return ShopRoutes::toLogin();
    }
}
