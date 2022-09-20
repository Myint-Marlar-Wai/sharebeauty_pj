<?php

declare(strict_types=1);

namespace App\Http\Requests\Seller\Auth\Guest;

use App\Auth\SellerAuth;
use App\Constants\Sessions\SellerSessions;
use App\Data\Common\EmailAddress;
use App\Http\Routes\SellerRoutes;
use App\Rules\EmailRule;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Log;

class VerifyEmailIndexForGuestRequest extends FormRequest
{
    const PARAM_EMAIL = 'email';
    const LANG_NAME = 'seller_verify_email_index_for_guest';
    const LANG_PREFIX = 'requests.'.self::LANG_NAME.'.';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $currentEmail = EmailAddress::tryFrom($this->session()->get(SellerSessions::VERIFY_EMAIL_TARGET_EMAIL));
        $inputEmail = EmailAddress::tryFrom($this->input(self::PARAM_EMAIL));
        if ($currentEmail === null) {
            return false;
        }
        if ($inputEmail === null) {
            return false;
        }
        if (! $currentEmail->equals($inputEmail)) {
            return false;
        }

        return true;
    }

//    public function getAuthUserOrNull(): ?\App\Auth\Models\SellerAuthUser
//    {
//        $guard = SellerAuth::guard();
//        if (! $guard->check() || ! $guard->hasUser()) {
//            return null;
//        }
//
//        return SellerAuth::user();
//    }

    public function getCurrentTargetEmail(): EmailAddress
    {
        return EmailAddress::from($this->session()->get(SellerSessions::VERIFY_EMAIL_TARGET_EMAIL));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            self::PARAM_EMAIL => ['required', new EmailRule()],
        ];
    }
}
