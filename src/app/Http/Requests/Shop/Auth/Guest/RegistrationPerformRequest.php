<?php

declare(strict_types=1);

namespace App\Http\Requests\Shop\Auth\Guest;

use App\Data\Common\EmailAddress;
use App\Data\Common\StrictPassword;
use App\Rules\EmailRule;
use App\Rules\PasswordRule;
use App\Rules\Support\PasswordType;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationPerformRequest extends FormRequest
{
    const PARAM_EMAIL = 'email';

    const PARAM_PASSWORD = 'password';

    const LANG_NAME = 'shop_member_registration';

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
            self::PARAM_EMAIL => ['required', 'string', new EmailRule()],
            self::PARAM_PASSWORD => ['required', 'string', new PasswordRule(PasswordType::Strict)],
        ];
    }

    public function getInputEmail() : EmailAddress
    {
        return EmailAddress::from($this->validated(self::PARAM_EMAIL));
    }
    public function getInputPassword() : StrictPassword
    {
        return StrictPassword::from($this->validated(self::PARAM_PASSWORD));
    }

}
