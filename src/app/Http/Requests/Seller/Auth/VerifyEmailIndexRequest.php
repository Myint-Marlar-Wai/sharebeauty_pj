<?php

declare(strict_types=1);

namespace App\Http\Requests\Seller\Auth;

use App\Auth\SellerAuth;
use App\Http\Requests\Seller\DefaultSellerUserRequest;
use Illuminate\Foundation\Http\FormRequest;

class VerifyEmailIndexRequest extends DefaultSellerUserRequest
{
    const LANG_NAME = 'seller_verify_email_index';
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
