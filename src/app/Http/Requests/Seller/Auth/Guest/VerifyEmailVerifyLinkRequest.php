<?php

declare(strict_types=1);

namespace App\Http\Requests\Seller\Auth\Guest;

use App\Data\Common\EmailAddress;
use App\Exceptions\AppExceptions;
use App\Rules\EmailRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Log;

class VerifyEmailVerifyLinkRequest extends FormRequest
{
    const PARAM_TOKEN = 'token';

    const PARAM_EMAIL = 'email';

    const LANG_NAME = 'seller_verify_email_verify';

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

    public function getInputEmail() : EmailAddress
    {
        return EmailAddress::from($this->validated(self::PARAM_EMAIL));
    }

    public function getRouteToken() : string
    {
        return $this->route(self::PARAM_TOKEN);
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

    protected function failedValidation(Validator $validator)
    {
        throw AppExceptions::badRequest();
    }
}
