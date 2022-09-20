<?php

declare(strict_types=1);

namespace App\Http\Requests\Demo;

use App\Data\Demo\DemoFormId;
use App\Http\Routes\DemoRoutes;
use Illuminate\Foundation\Http\FormRequest;

/**
 *
 */
class DemoFormShowRequest extends FormRequest
{

    public function getDemoFormId(): DemoFormId
    {
        return DemoFormId::from($this->route(DemoRoutes::PARAM_FORM_ID));
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

    public function messages(): array
    {
        return [
        ];
    }

}
