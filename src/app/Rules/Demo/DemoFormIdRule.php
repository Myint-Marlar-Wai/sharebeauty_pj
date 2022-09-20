<?php

declare(strict_types=1);

namespace App\Rules\Demo;

use App\Data\Demo\DemoFormId;
use App\Rules\Base\BaseRule;
use App\Rules\Support\FailClosure;

class DemoFormIdRule extends BaseRule
{
    const TYPE_NAME = DemoFormId::TYPE_NAME;

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
        if ($value instanceof DemoFormId) {
            // passed
            return;
        }
        if (DemoFormId::tryFromIntString(strval($value)) === null) {
            // fail
            $fail($this->message('base'))->translate();
        }
    }
}
