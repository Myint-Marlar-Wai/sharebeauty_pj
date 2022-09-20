<?php

declare(strict_types=1);

namespace App\Http\Controllers\Seller\Auth\Guest;

use App\Auth\SellerAuth;
use App\Constants\Sessions\SellerSessions;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use App\Exceptions\Basic\AppUserAlreadyExistsException;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\Seller\Auth\Guest\AuthGoogleCallbackRequest;
use App\Http\Requests\Seller\Auth\Guest\AuthGoogleRequest;
use App\Http\Routes\SellerRoutes;
use App\Services\SellerUser\SellerUserService;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;

class GoogleAuthController extends BaseController
{
    public function __construct(
        public SellerUserService $userService
    ) {
    }

    protected function googleProvider() : GoogleProvider
    {
        return Socialite::driver('google');
    }

    /**
     * @param AuthGoogleRequest $request
     * @return RedirectResponse
     */
    public function getRedirectToGoogleForLogin(AuthGoogleRequest $request): RedirectResponse
    {
        $response = $this->googleProvider()
            ->with([
                'prompt' => 'select_account',
            ])
            ->redirect();

        return $this->attachState(
            $request,
            $response,
            AuthGoogleCallbackRequest::APP_ACTION_LOGIN
        );
    }

    /**
     * @param \App\Http\Requests\Seller\Auth\Guest\AuthGoogleRequest $request
     * @return RedirectResponse
     */
    public function getRedirectToGoogleForRegistration(AuthGoogleRequest $request): RedirectResponse
    {
        $response = $this->googleProvider()
            ->with([
                'prompt' => 'select_account',
            ])
            ->redirect();

        return $this->attachState(
            $request,
            $response,
            AuthGoogleCallbackRequest::APP_ACTION_REGISTRATION
        );
    }

    protected function makeRedirectUrl(string $appAction): string
    {
        $url = route(SellerRoutes::AUTH_GOOGLE_CALLBACK, [
            //AuthGoogleCallbackRequest::PARAM_APP_ACTION => $appAction,
        ]);
        Log::debug('google-callback-url '.$url);

        return $url;
    }

    protected function attachState(AuthGoogleRequest $request, RedirectResponse $response, string $appAction): RedirectResponse
    {
        $session = $request->session();
        $session->put(SellerSessions::AUTH_GOOGLE_APP_ACTION, $appAction);

        return $response;
    }

    /**
     * @throws ValidationException
     */
    public function getGoogleCallback(AuthGoogleCallbackRequest $request): \Illuminate\Contracts\View\View|RedirectResponse
    {
        $action = $request->session()->pull(SellerSessions::AUTH_GOOGLE_APP_ACTION);
        if ($action === AuthGoogleCallbackRequest::APP_ACTION_LOGIN) {
            return $this->handleLogin($request);
        } elseif ($action === AuthGoogleCallbackRequest::APP_ACTION_REGISTRATION) {
            return $this->handleRegistration($request);
        } else {
            throw AppExceptions::badRequest();
        }
    }

    /**
     * @throws ValidationException
     */
    protected function handleLogin(AuthGoogleCallbackRequest $request): RedirectResponse
    {
        $googleUser = $request->handleCallback($this->googleProvider());

        $guard = $request->getGuard();
        $credentials = [
            'google_user' => $googleUser,
        ];
        if (! $guard->attempt($credentials, false)) {
            throw ValidationException::withMessages([
                AuthGoogleRequest::CALLBACK_PARAM_GOOGLE => trans(\App\Http\Requests\Seller\Auth\Guest\LoginPerformRequest::LANG_AUTH_FAILED),
            ])->redirectTo(SellerRoutes::urlLogin());
        }

        //$request->session()->regenerate();

        return redirect()->intended(SellerRoutes::urlHome());
    }

    /**
     * @throws ValidationException
     */
    protected function handleRegistration(AuthGoogleCallbackRequest $request): RedirectResponse
    {
        $request->handleCallback($this->googleProvider());
        $googleId = $request->getGoogleId();
        $googleEmail = $request->getGoogleEmail();
        $googleEmailVerified = $request->isGoogleEmailVerified();

        try {
            $user = $this->userService->registerByGoogle(
                googleId: $googleId,
                email: $googleEmail,
                isEmailVerified: $googleEmailVerified
            );
        } catch (AppUserAlreadyExistsException $ex) {
            throw ValidationException::withMessages([
                AuthGoogleRequest::CALLBACK_PARAM_GOOGLE => $ex->resolveInfo()->message,
            ])->redirectTo(SellerRoutes::urlRegistration());
        }

        $userProvider = SellerAuth::getUserProvider();
        $authUser = $userProvider->retrieveById($user->id);
        if (! $authUser) {
            throw AppExceptions::logicException(AppErrorCode::LOGIC_EXCEPTION_GENERAL);
        }

        $guard = $request->getGuard();
        $guard->login($authUser);

        //$request->session()->regenerate();

        event(new Registered($authUser));

        return SellerRoutes::toHome();
    }
}
