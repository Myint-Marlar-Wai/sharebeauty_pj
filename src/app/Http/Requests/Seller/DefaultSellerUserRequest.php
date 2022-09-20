<?php

declare(strict_types=1);

namespace App\Http\Requests\Seller;

use App\Http\Requests\Seller\Base\BaseSellerUserRequest;

class DefaultSellerUserRequest extends BaseSellerUserRequest
{

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
        ];
    }


}
