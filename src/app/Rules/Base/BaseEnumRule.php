<?php

declare(strict_types=1);

namespace App\Rules\Base;

use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use App\Rules\Support\FailClosure;
use Closure;
use InvalidArgumentException;
use TypeError;

abstract class BaseEnumRule extends BaseRule
{
    const TYPE_NAME = 'base_enum';

    /**
     * The type of the enum.
     *
     * @var string
     */
    protected string $type;

    /**
     * Create a new rule instance.
     *
     * @param  string  $type
     */
    public function __construct(string $type)
    {
        parent::__construct();
        $this->type = $type;
        if (! function_exists('enum_exists') || ! enum_exists($this->type) || ! method_exists($this->type, 'tryFrom')) {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_RULE_BASE_ENUM_CLASS_TYPE);
        }
        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure|FailClosure $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail): void
    {
        if (! $this->passesEnum($value)) {
            $this->failDefault($attribute, $value, $fail);
        }
    }

    protected function passesEnum($value) : bool
    {
        if ($value === null) {
            return false;
        }

        if ($value instanceof $this->type) {
            // passed
            return true;
        }

        try {
            return method_exists($this->type, 'tryFrom') &&
                ! is_null($this->type::tryFrom($value));
        } catch (TypeError $e) {
            return false;
        }
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @param Closure|FailClosure $fail
     */
    protected function failDefault(string $attribute, mixed $value, Closure|FailClosure $fail)
    {
        $fail($this->messageTable['base'])->translate();
    }

}
