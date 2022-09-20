<?php

declare(strict_types=1);

namespace App\Http\Requests\Seller\Auth\Guest;

use App\Data\Common\EmailAddress;
use App\Data\Common\StrictPassword;
use App\Rules\EmailRule;
use App\Rules\PasswordRule;
use App\Rules\Support\PasswordType;
use Illuminate\Foundation\Http\FormRequest;

class PasswordResetUpdatePerformRequest extends FormRequest
{
    const PARAM_TOKEN = 'token';

    const PARAM_EMAIL = 'email';

    const PARAM_NEW_PASSWORD = 'new_password';

    const LANG_NAME = 'seller_password_reset_update';

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
            self::PARAM_TOKEN => ['required'],
            self::PARAM_EMAIL => ['required', new EmailRule()],
            self::PARAM_NEW_PASSWORD => ['required', 'string', new PasswordRule(PasswordType::Strict)],
        ];
    }

    public function getInputToken() : string
    {
        return $this->validated(self::PARAM_TOKEN);
    }

    public function getInputEmail() : EmailAddress
    {
        return EmailAddress::from($this->validated(self::PARAM_EMAIL));
    }

    public function getInputNewPassword() : StrictPassword
    {
        return StrictPassword::from($this->validated(self::PARAM_NEW_PASSWORD));
    }
}
