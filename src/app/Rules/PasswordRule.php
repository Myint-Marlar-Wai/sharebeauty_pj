<?php

declare(strict_types=1);

namespace App\Rules;

use App\Data\Common\Password;
use App\Data\Common\StrictPassword;
use App\Exceptions\AppErrorCode;
use App\Exceptions\Logic\AppInvalidArgumentException;
use App\Rules\Base\BaseRule;
use App\Rules\Support\FailClosure;
use App\Rules\Support\PasswordType;

class PasswordRule extends BaseRule
{
    const TYPE_NAME = Password::TYPE_NAME;

    public function __construct(
        public PasswordType $passwordType
    ) {
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
        if ($value instanceof StrictPassword) {
            // passed
            return;
        }
        try {
            StrictPassword::fromString(strval($value));
        } catch (AppInvalidArgumentException $ex) {
            // fail
            match ($ex->getAppErrorCode()) {
                AppErrorCode::INVALID_ARGUMENT_PASSWORD_LOWERCASE_LETTERS => $fail($this->message('lowercase_letters'))->translate(),
                AppErrorCode::INVALID_ARGUMENT_PASSWORD_UPPERCASE_LETTERS => $fail($this->message('uppercase_letters'))->translate(),
                AppErrorCode::INVALID_ARGUMENT_PASSWORD_NUMBERS => $fail($this->message('numbers'))->translate(),
                AppErrorCode::INVALID_ARGUMENT_PASSWORD_SYMBOLS => $fail($this->message('symbols'))->translate(),
                default => $fail($this->message('base'))->translate(),
            };

            return;
        }
    }
}
