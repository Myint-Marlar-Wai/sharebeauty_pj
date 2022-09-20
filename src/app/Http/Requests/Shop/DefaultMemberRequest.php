<?php

declare(strict_types=1);

namespace App\Http\Requests\Shop;

use App\Http\Requests\Shop\Base\BaseMemberRequest;

class DefaultMemberRequest extends BaseMemberRequest
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
