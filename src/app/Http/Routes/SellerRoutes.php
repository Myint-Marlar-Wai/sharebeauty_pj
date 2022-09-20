<?php

declare(strict_types=1);

namespace App\Http\Routes;

use App\Data\Common\EmailAddress;
use App\Data\Shop\ShopId;
use App\Http\Requests\Seller\Auth\Guest\VerifyEmailIndexForGuestRequest;
use App\Http\Requests\Seller\Auth\Guest\VerifyEmailVerifyPerformRequest;
use App\Http\Routes\Enums\ShopFooterActiveTab;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\URL;
use Log;

final class SellerRoutes
{
    private function __construct()
    {
    }

    // 一番最初のページ
    const HOME = 'home';

    // Login
    const LOGIN = 'login';
    const LOGIN_PERFORM = 'login.perform';
    const LOGOUT_PERFORM = 'logout.perform';

    // Auth Google
    const AUTH_GOOGLE_FOR_LOGIN = 'auth.google.for_login';
    const AUTH_GOOGLE_FOR_REGISTRATION = 'auth.google.for_registration';
    const AUTH_GOOGLE_CALLBACK = 'auth.google.callback';

    // Register
    const REGISTER = 'register';
    const REGISTER_PERFORM = 'register.perform';

    // Verification
    const VERIFICATION_NOTICE_INDEX = 'verification.notice';
    const VERIFICATION_NOTICE_INDEX_EMAIL = 'verification.notice.email';
    const VERIFICATION_SEND = 'verification.send';
    const VERIFICATION_VERIFY = 'verification.verify';
    const VERIFICATION_VERIFY_PERFORM = 'verification.verify.perform';
    const VERIFICATION_VERIFY_COMPLETED = 'verification.verify.completed';

    // Password Change
    const PASSWORD_CHANGE = 'password.change';
    const PASSWORD_CHANGE_PERFORM = 'password.change.perform';
    const PASSWORD_CHANGE_COMPLETED = 'password.change.completed';

    // Password Reset
    const PASSWORD_RESET_INDEX = 'password.request';
    const PASSWORD_RESET_SEND_LINK = 'password.email';
    const PASSWORD_RESET_SEND_LINK_COMPLETED = 'password.email.completed';
    const PASSWORD_RESET_LINK = 'password.reset';
    const PASSWORD_RESET_UPDATE_PERFORM = 'password.update.perform';
    const PASSWORD_RESET_UPDATE_COMPLETED = 'password.update.completed';

    // Content
    const SHOPS = 'shops';
    const SHOP_DETAIL = 'shop.detail';
    const SALES = 'sales';
    const SETTING = 'setting';
    const SUPPORT = 'support';

    /*
    |--------------------------------------------------------------------------
    | Param
    |--------------------------------------------------------------------------
    |
    |
    */

    const PARAM_DISPLAY_SHOP_ID = 'display_shop_id';
    const PARAM_SHOP_ID = 'shop_id';

    /*
    |--------------------------------------------------------------------------
    | Seller Web Login
    |--------------------------------------------------------------------------
    |
    |
    */

    public static function urlLogin(): string
    {
        return route(self::LOGIN);
    }

    public static function toLogin(): RedirectResponse
    {
        return to_route(self::LOGIN);
    }

    public static function urlLogoutPerform(): string
    {
        return route(self::LOGOUT_PERFORM);
    }

    public static function urlRegistration(): string
    {
        return route(self::REGISTER);
    }

    public static function urlLoginPerform(): string
    {
        return route(self::LOGIN_PERFORM);
    }

    public static function urlRegistrationPerform(): string
    {
        return route(self::REGISTER_PERFORM);
    }

    public static function urlAuthGoogleForLogin(): string
    {
        return route(self::AUTH_GOOGLE_FOR_LOGIN);
    }

    public static function urlAuthGoogleForRegistration(): string
    {
        return route(self::AUTH_GOOGLE_FOR_REGISTRATION);
    }

    public static function urlPasswordChange(): string
    {
        return route(self::PASSWORD_CHANGE);
    }

    public static function urlPasswordChangePerform(): string
    {
        return route(self::PASSWORD_CHANGE_PERFORM);
    }

    public static function toPasswordChangeCompleted(): RedirectResponse
    {
        return to_route(self::PASSWORD_CHANGE_COMPLETED);
    }

    public static function urlPasswordReset(): string
    {
        return route(self::PASSWORD_RESET_INDEX);
    }

    public static function urlPasswordResetSendLink(): string
    {
        return route(self::PASSWORD_RESET_SEND_LINK);
    }

    public static function toPasswordResetSendLinkCompleted(): RedirectResponse
    {
        return to_route(self::PASSWORD_RESET_SEND_LINK_COMPLETED);
    }

    public static function singedUrlPasswordResetLink(string $token, EmailAddress $email, CarbonImmutable $expiration): string
    {
        return URL::temporarySignedRoute(
            self::PASSWORD_RESET_LINK,
            $expiration,
            [
                'token' => $token,
                'email' => $email->getString(),
            ]
        );
    }

    public static function urlPasswordResetUpdatePerform(): string
    {
        return route(self::PASSWORD_RESET_UPDATE_PERFORM);
    }

    public static function toPasswordResetUpdateCompleted(): RedirectResponse
    {
        return to_route(self::PASSWORD_RESET_UPDATE_COMPLETED);
    }

    public static function toVerificationNoticeIndex(): RedirectResponse
    {
        return to_route(self::VERIFICATION_NOTICE_INDEX);
    }

    public static function toVerificationNoticeIndexWithEmail(
        EmailAddress $email,
    ): RedirectResponse {
        return to_route(self::VERIFICATION_NOTICE_INDEX_EMAIL, [
            VerifyEmailIndexForGuestRequest::PARAM_EMAIL => $email->getString(),
        ]);
    }

    public static function urlVerifyEmailSendPerform(): string
    {
        return route(self::VERIFICATION_SEND);
    }

    public static function urlVerifyEmailVerifyPerform(): string
    {
        return route(self::VERIFICATION_VERIFY_PERFORM);
    }

    public static function toVerificationVerifyCompleted(): RedirectResponse
    {
        return to_route(self::VERIFICATION_VERIFY_COMPLETED);
    }

    public static function signedUrlVerificationVerifyLink(string $token, EmailAddress $email, CarbonImmutable $expiration): string
    {
        return URL::temporarySignedRoute(
            self::VERIFICATION_VERIFY,
            $expiration,
            [
                VerifyEmailVerifyPerformRequest::PARAM_TOKEN => $token,
                VerifyEmailVerifyPerformRequest::PARAM_EMAIL => $email->getString(),
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Seller Web Home
    |--------------------------------------------------------------------------
    |
    |
    */

    public static function urlShopDetail(ShopId $id): string
    {
        return route(self::SHOP_DETAIL, [self::PARAM_SHOP_ID => $id->getIntString()]);
    }

    public static function urlHome(): string
    {
        return route(self::HOME);
    }

    public static function toHome(): RedirectResponse
    {
        return to_route(self::HOME);
    }

    public static function urlShops(): string
    {
        return route(self::SHOPS);
    }

    public static function toShops(): RedirectResponse
    {
        return to_route(self::SHOPS);
    }

    public static function urlSales(): string
    {
        return route(self::SALES);
    }

    public static function urlSetting(): string
    {
        return route(self::SETTING);
    }

    public static function urlSupport(): string
    {
        return route(self::SUPPORT);
    }

    public static function getShopFooterActiveTab(?string $url = null): ?ShopFooterActiveTab
    {
        if ($url === null) {
            $url = URL::current();
        }
        $shopsUrl = self::urlShops();
        Log::debug('shop-footer-active-tab', ['url' => $url, 'shops' => $shopsUrl]);
        if (str_starts_with($url, $shopsUrl)) {
            return ShopFooterActiveTab::Shops;
        }

        return null;
    }
}
