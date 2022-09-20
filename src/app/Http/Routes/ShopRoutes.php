<?php

declare(strict_types=1);

namespace App\Http\Routes;

use App\Data\Common\EmailAddress;
use App\Http\Requests\Shop\Auth\VerifyEmailVerifyRequest;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\URL;
use Log;
use Str;

final class ShopRoutes
{
    private function __construct()
    {
    }

    // 一番最初のページ
    const HOME = 'home';

    const LOGIN = 'login';
    const LOGIN_PERFORM = 'login.perform';
    const LOGOUT_PERFORM = 'logout.perform';

    const REGISTER = 'register';
    const REGISTER_PERFORM = 'register.perform';

    const VERIFICATION_NOTICE_INDEX = 'verification.notice';
    const VERIFICATION_SEND = 'verification.send';
    const VERIFICATION_VERIFY = 'verification.verify';
    const VERIFICATION_VERIFY_COMPLETED = 'verification.verify.completed';

    const PASSWORD_CHANGE = 'password.change';
    const PASSWORD_CHANGE_PERFORM = 'password.change.perform';
    const PASSWORD_CHANGE_COMPLETED = 'password.change.completed';

    const PASSWORD_RESET_INDEX = 'password.request';
    const PASSWORD_RESET_SEND_LINK = 'password.email';
    const PASSWORD_RESET_SEND_LINK_COMPLETED = 'password.email.completed';
    const PASSWORD_RESET_LINK = 'password.reset';
    const PASSWORD_RESET_UPDATE_PERFORM = 'password.update.perform';
    const PASSWORD_RESET_UPDATE_COMPLETED = 'password.update.completed';

    const MEMBER = 'member';
    const MEMBER_SHIPPING = 'member.shipping';

    /*
    |--------------------------------------------------------------------------
    | Param
    |--------------------------------------------------------------------------
    |
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Shop Web Login
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

    public static function urlLoginPerform() : string
    {
        return route(self::LOGIN_PERFORM);
    }

    public static function urlRegistrationPerform() : string
    {
        return route(self::REGISTER_PERFORM);
    }

    public static function toVerificationNoticeIndex(): RedirectResponse
    {
        return to_route(self::VERIFICATION_NOTICE_INDEX);
    }

    public static function urlVerifyEmailSend() : string
    {
        return route(self::VERIFICATION_SEND);
    }

    public static function toVerificationVerifyCompleted(): RedirectResponse
    {
        return to_route(self::VERIFICATION_VERIFY_COMPLETED);
    }

    public static function urlPasswordChange() : string
    {
        return route(self::PASSWORD_CHANGE);
    }

    public static function urlPasswordChangePerform() : string
    {
        return route(self::PASSWORD_CHANGE_PERFORM);
    }

    public static function toPasswordChangeCompleted(): RedirectResponse
    {
        return to_route(self::PASSWORD_CHANGE_COMPLETED);
    }

    public static function urlPasswordReset() : string
    {
        return route(self::PASSWORD_RESET_INDEX);
    }

    public static function urlPasswordResetSendLink() : string
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

    public static function urlPasswordResetUpdatePerform() : string
    {
        return route(self::PASSWORD_RESET_UPDATE_PERFORM);
    }

    public static function toPasswordResetUpdateCompleted(): RedirectResponse
    {
        return to_route(self::PASSWORD_RESET_UPDATE_COMPLETED);
    }

    public static function signedUrlVerificationVerifyLink(string $token, EmailAddress $email, CarbonImmutable $expiration): string
    {
        return URL::temporarySignedRoute(
            self::VERIFICATION_VERIFY,
            $expiration,
            [
                VerifyEmailVerifyRequest::PARAM_TOKEN => $token,
                VerifyEmailVerifyRequest::PARAM_EMAIL => $email->getString(),
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Shop Web Home
    |--------------------------------------------------------------------------
    |
    |
    */

    public static function urlHome() : string
    {
        return route(self::HOME);
    }

    public static function toHome(): RedirectResponse
    {
        return to_route(self::HOME);
    }

    public static function urlMember(): string
    {
        return route(self::MEMBER);
    }
}
