<?php

declare(strict_types=1);

namespace App\Http\Requests\Seller\Auth\Guest;

use App\Data\Common\EmailAddress;
use App\Rules\EmailRule;
use Illuminate\Foundation\Http\FormRequest;

class PasswordResetSendLinkRequest extends FormRequest
{
    const PARAM_EMAIL = 'email';

    const LANG_NAME = 'seller_password_reset_send_link';

    const LANG_PREFIX = 'requests.'.self::LANG_NAME.'.';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
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

    public function getInputEmail() : EmailAddress
    {
        return EmailAddress::from($this->validated(self::PARAM_EMAIL));
    }


}
