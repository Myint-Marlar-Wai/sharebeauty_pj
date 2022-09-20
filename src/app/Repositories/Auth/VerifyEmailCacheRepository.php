<?php

declare(strict_types=1);

namespace App\Repositories\Auth;

use App\Components\App\HashKey;
use App\Data\Auth\VerifyEmailData;
use App\Data\Auth\VerifyEmailGroup;
use App\Data\Common\EmailAddress;
use App\Data\SellerUser\SellerId;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use App\Repositories\Base\BaseRepository;
use Cache;
use Carbon\CarbonImmutable;
use Illuminate\Support\Str;
use Psr\SimpleCache\InvalidArgumentException;
use UnexpectedValueException;

class VerifyEmailCacheRepository extends BaseRepository implements VerifyEmailRepository
{
    const KEY_PREFIX_VERIFY_EMAIL = 'verify-email.';

    public string $hashKey;

    public function __construct(
        HashKey $hashKeyContract,
    ) {
        $this->hashKey = $hashKeyContract->getValue();
    }

    protected function store(): \Illuminate\Contracts\Cache\Repository
    {
        return Cache::store();
    }

    protected function putObject(string $key, object $value, CarbonImmutable $expiration): void
    {
        $this->store()->put($key, $value, $expiration);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function getObjectOrNull(string $key, ?object $defaultValue = null): ?object
    {
        return $this->store()->get($key, $defaultValue);
    }

    protected function deleteByKey(string $key)
    {
        $this->store()->forget($key);
    }

    protected function keyOfVerifyEmail(VerifyEmailGroup $group, string $token): string
    {
        $type = $group->value;

        return self::KEY_PREFIX_VERIFY_EMAIL.$type.'.'.$token;
    }

    /**
     * Create a new token
     *
     * @param callable $validChecker
     * @return string
     */
    protected function createNewToken(callable $validChecker): string
    {
        for ($i = 1; $i <= 10; $i++) {
            $token = hash_hmac('sha256', Str::random(40), $this->hashKey);
            $valid = $validChecker($token);
            if (! is_bool($valid)) {
                throw new UnexpectedValueException();
            }
            if ($valid) {
                return $token;
            }
        }

        return throw AppExceptions::runtimeException(AppErrorCode::RUNTIME_EXCEPTION_CANT_GENERATE_NEW_TOKEN);
    }

    public function createVerifyEmail(VerifyEmailGroup $group, EmailAddress $email, CarbonImmutable $expiration): VerifyEmailData
    {
        $newToken = $this->createNewToken(
            /** @throws InvalidArgumentException */
            function ($token) use ($group): bool {
                return $this->getVerifyEmailByToken($group, $token) === null;
            });
        $key = $this->keyOfVerifyEmail($group, $newToken);
        $data = new VerifyEmailData(
            token: $newToken,
            group: $group,
            email: $email,
            expiration: $expiration
        );
        $this->putObject($key, $data, $data->expiration);

        return $data;
    }

    public function updateVerifyEmail(VerifyEmailData $data)
    {
        $key = $this->keyOfVerifyEmail($data->group, $data->token);
        $this->putObject($key, $data, $data->expiration);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getVerifyEmailByToken(VerifyEmailGroup $group, string $token): ?VerifyEmailData
    {
        $data = $this->getObjectOrNull($this->keyOfVerifyEmail($group, $token));

        if ($data === null) {
            return null;
        }
        assert($data instanceof VerifyEmailData);

        return $data;
    }

    public function deleteVerifyEmail(VerifyEmailGroup $group, string $token)
    {
        $this->deleteByKey($this->keyOfVerifyEmail($group, $token));
    }
}
