<?php

declare(strict_types=1);

namespace App\Rules;

use App\Data\Bank\BankCode;
use App\Data\Demo\DemoFormId;
use App\Rules\Base\BaseRule;
use App\Rules\Support\FailClosure;

class BankCodeRule extends BaseRule
{

    const TYPE_NAME = BankCode::TYPE_NAME;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure|FailClosure $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail): void
    {
        if ($value instanceof BankCode) {
            // passed
            return;
        }
        if (BankCode::tryFromString(strval($value)) === null) {
            // fail
            $fail($this->message('base'))->translate();
        }
    }
}
