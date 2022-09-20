<?php

declare(strict_types=1);

namespace App\Http\Requests\Seller\Auth\Guest;

use Illuminate\Foundation\Http\FormRequest;

class AuthGoogleRequest extends FormRequest
{
    const CALLBACK_PARAM_GOOGLE = 'google_id';

    const LANG_NAME = 'seller_auth_google';

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

        ];
    }

}
