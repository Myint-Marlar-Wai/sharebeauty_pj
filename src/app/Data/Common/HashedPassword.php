<?php

declare(strict_types=1);

namespace App\Data\Common;

use App\Auth\SellerAuth;
use App\Auth\Support\Hasheres;
use App\Data\Base\StringCode;
use App\Data\Base\StringCodeFactory;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use InvalidArgumentException;

final class HashedPassword extends StringCode
{
    use StringCodeFactory;

    const TYPE_NAME = 'hashed_password';

    protected function validateValue(string $value): void
    {
        if ($value === '') {
            throw AppExceptions::invalidArgumentException(
                AppErrorCode::INVALID_ARGUMENT_PASSWORD);
        }
    }

    public function matchWithPlain(?Password $plain): bool
    {
        $hasher = Hasheres::getHasher();
        $hashed = $this;
        $plainValue = $plain->getString();
        $hashedValue = $hashed->getString();
        return $hasher->check($plainValue, $hashedValue);
    }

    /**
     * @param Password $plain
     * @return static
     */
    public static function fromPlain(Password $plain): static
    {
        $hasher = Hasheres::getHasher();
        return self::fromString($hasher->make($plain->getString()));
    }
}
