<?php

declare(strict_types=1);

namespace App\Http\Requests\Demo;

use App\Data\Bank\BankAccountType;
use App\Data\Bank\BankCode;
use App\Data\Demo\DemoFormEnum;
use App\Data\Demo\DemoFormId;
use App\Data\Order\DisplayOrderId;
use App\Http\Routes\DemoRoutes;
use App\Rules\BankAccountTypeRule;
use App\Rules\BankCodeRule;
use App\Rules\Demo\DemoFormEnumRule;
use App\Rules\DisplayOrderIdRule;
use App\Services\Demo\DemoFormUpdateInput;
use Illuminate\Foundation\Http\FormRequest;

class DemoFormUpdateRequest extends FormRequest
{
    const PARAM_BANK_CODE = 'bank_code';

    const PARAM_BANK_ACCOUNT_TYPE = 'bank_account_type';

    const PARAM_DISPLAY_ORDER_ID = 'display_order_id';

    const PARAM_DEMO_FORM_ENUM = 'demo_form_enum';

    const LANG_NAME = 'demo_web_form';

    const LANG_PREFIX = 'requests.'.self::LANG_NAME.'.';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'display_order_id' => [
                'required',
                (new DisplayOrderIdRule())->setMessages([
                    // オーバーライドサンプル
                    'base' => self::LANG_PREFIX.'display_order_id.base',
                ]),
            ],
            'demo_form_enum' => [
                'required',
                new DemoFormEnumRule(),
            ],
            'bank_code' => [
                'required',
                new BankCodeRule(),
            ],
            'bank_account_type' => [
                'required',
                new BankAccountTypeRule(),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            // オーバーライドサンプル
            'display_order_id.required' => trans(self::LANG_PREFIX.'display_order_id.required'),
        ];
    }

    public function getDemoFormId(): DemoFormId
    {
        return DemoFormId::from($this->route(DemoRoutes::PARAM_FORM_ID));
    }

    public function getBankCode(): BankCode
    {
        return BankCode::from($this->validated(self::PARAM_BANK_CODE));
    }

    public function getBankAccountType(): BankAccountType
    {
        return BankAccountType::from($this->validated(self::PARAM_BANK_ACCOUNT_TYPE));
    }

    public function getDisplayOrderId(): DisplayOrderId
    {
        return DisplayOrderId::from($this->validated(self::PARAM_DISPLAY_ORDER_ID));
    }

    public function getDemoFormEnum(): DemoFormEnum
    {
        return DemoFormEnum::from($this->validated(self::PARAM_DEMO_FORM_ENUM));
    }

    public function makeUpdateInput(): DemoFormUpdateInput
    {
        $request = $this;
        $demoFormId = $request->getDemoFormId();
        $input = DemoFormUpdateInput::makeWithId($demoFormId);
        $input->alpha->bankCode = $request->getBankCode();
        $input->alpha->bankAccountType = $request->getBankAccountType();
        $input->bravo->displayOrderId = $request->getDisplayOrderId();
        $input->bravo->demoFormEnum = $request->getDemoFormEnum();
        return $input;
    }
}
