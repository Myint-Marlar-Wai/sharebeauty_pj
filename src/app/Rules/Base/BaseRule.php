<?php

declare(strict_types=1);

namespace App\Rules\Base;

use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use App\Rules\Support\FailClosure;
use Illuminate\Contracts\Validation\InvokableRule;

abstract class BaseRule implements InvokableRule
{
    const TYPE_NAME = 'base_value';

    protected const LANG_DTO_PREFIX = 'data.rules.';

    protected static function defTransKey(?string $name) :  string
    {
        if ($name !== null) {
            return static::LANG_DTO_PREFIX.static::TYPE_NAME.'.'.$name;
        } else {
            return static::LANG_DTO_PREFIX.static::TYPE_NAME;
        }
    }

    /**
     * @var string[]
     */
    protected array $messageTable = [];

    public function __construct()
    {
        $transKey = self::defTransKey(null);
        $transList = trans($transKey);
        if (! is_array($transList) || ! $transList) {
            throw AppExceptions::logicException(
                AppErrorCode::LOGIC_EXCEPTION_NO_DEF_BASE_RULE_LANG);
        }
        foreach ($transList as $key => $value) {
            $this->setMessage($key, $transKey.'.'.$key);
        }

        return $this;
    }

    /**
     * @param string[] $messages
     * @return static
     */
    public function setMessages(array $messages): static
    {
        $this->messageTable = array_merge($this->messageTable, $messages);

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @return static
     */
    public function setMessage(string $key, $value): static
    {
        $this->messageTable[$key] = $value;

        return $this;
    }

    protected function message($key) : string
    {
        return $this->messageTable[$key];
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure|FailClosure $fail
     * @return void
     */
    abstract public function __invoke($attribute, $value, $fail): void;
}
