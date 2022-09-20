<?php

declare(strict_types=1);

namespace App\Http\Requests\Seller\Auth;

use App\Auth\SellerAuth;
use App\Data\Common\EmailAddress;
use App\Http\Requests\Seller\DefaultSellerUserRequest;
use App\Rules\EmailRule;

class VerifyEmailSendPerformRequest extends DefaultSellerUserRequest
{
    const PARAM_EMAIL = 'email';

    const LANG_NAME = 'seller_verify_email_send_perform';

    const LANG_PREFIX = 'requests.'.self::LANG_NAME.'.';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $inputEmail = EmailAddress::tryFrom($this->input(self::PARAM_EMAIL));
        if ($inputEmail === null) {
            return false;
        }
        $authUser = SellerAuth::user();
        $currentEmail = $authUser->getEmailAddress();
        if (! $currentEmail->equals($inputEmail)) {
            return false;
        }

        return true;
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
