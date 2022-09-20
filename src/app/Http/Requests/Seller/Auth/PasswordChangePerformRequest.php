<?php

declare(strict_types=1);

namespace App\Http\Requests\Seller\Auth;

use App\Data\Common\LoosePassword;
use App\Data\Common\StrictPassword;
use App\Http\Requests\Seller\Base\BaseSellerUserRequest;
use App\Rules\PasswordRule;
use App\Rules\Support\PasswordType;

class PasswordChangePerformRequest extends BaseSellerUserRequest
{
    const PARAM_CURRENT_PASSWORD = 'current_password';

    const PARAM_NEW_PASSWORD = 'new_password';

    const LANG_NAME = 'seller_password_change';

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
    public function rules()
    {
        return [
            self::PARAM_CURRENT_PASSWORD => ['required', 'string', new PasswordRule(PasswordType::Loose)],
            self::PARAM_NEW_PASSWORD => ['required', 'string', new PasswordRule(PasswordType::Strict)],
        ];
    }

    public function getInputCurrentPassword() : LoosePassword
    {
        return LoosePassword::from($this->validated(self::PARAM_CURRENT_PASSWORD));
    }
    public function getInputNewPassword() : StrictPassword
    {
        return StrictPassword::from($this->validated(self::PARAM_NEW_PASSWORD));
    }

}
