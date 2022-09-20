<?php

declare(strict_types=1);

namespace App\Auth\Models;

use App\Constants\Configs\AuthConfig;
use App\Constants\Sessions\SellerSessions;
use App\Data\Auth\VerifyEmailData;
use App\Data\Auth\VerifyEmailGroup;
use App\Data\Common\EmailAddress;
use App\Data\Common\GoogleId;
use App\Data\Common\HashedPassword;
use App\Data\Common\Password;
use App\Data\SellerUser\SellerAuthData;
use App\Data\SellerUser\SellerId;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use App\Notifications\PasswordResetNotification;
use App\Notifications\VerifyEmailNotification;
use App\Repositories\Auth\VerifyEmailRepository;
use App\Repositories\SellerUser\SellerUserRepository;
use App\Repositories\Support\TransactionResolver;
use App\Services\SellerUser\SellerUserService;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;

class SellerDefaultAuthUser implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, SellerAuthUser, VerifyEmailExecutor /* MustVerifyEmailContract */
{
    use Authorizable, Notifiable, CanResetPassword, MustVerifyEmailTrait {
        CanResetPassword::sendPasswordResetNotification as sendPasswordResetNotificationDefault;
    }

    protected SellerId $userId;

    protected EmailAddress $emailAddress;

    protected ?CarbonImmutable $emailVerifiedAt = null;

    protected ?HashedPassword $hashedPassword = null;

    protected ?GoogleId $googleId;

    protected ?CarbonImmutable $migratedAt;

    protected ?CarbonImmutable $registrationCompletedAt;

    protected ?string $rememberToken = null;

    /**
     * 認証ユーザーからソースデータを扱いたい場合用
     * @var SellerAuthData|null
     */
    protected ?SellerAuthData $userData = null;

    /**
     * @param SellerId $userId
     * @param EmailAddress $email
     * @param CarbonImmutable|null $emailVerifiedAt
     * @param HashedPassword|null $hashedPassword
     * @param GoogleId|null $googleId
     * @param CarbonImmutable|null $migratedAt
     * @param CarbonImmutable|null $registrationCompletedAt
     * @param string|null $rememberToken
     * @param SellerAuthData|null $userData
     */
    public function __construct(
        SellerId $userId,
        EmailAddress $email,
        ?CarbonImmutable $emailVerifiedAt,
        ?HashedPassword $hashedPassword,
        ?GoogleId $googleId,
        ?CarbonImmutable $migratedAt,
        ?CarbonImmutable $registrationCompletedAt,
        ?string $rememberToken,
        ?SellerAuthData $userData
    ) {
        $this->userId = $userId;
        $this->emailAddress = $email;
        $this->emailVerifiedAt = $emailVerifiedAt;
        $this->hashedPassword = $hashedPassword;
        $this->googleId = $googleId;
        $this->migratedAt = $migratedAt;
        $this->registrationCompletedAt = $registrationCompletedAt;
        $this->rememberToken = $rememberToken;
        $this->userData = $userData;
    }

    protected function getUserRepository() : SellerUserRepository
    {
        return app()->make(SellerUserRepository::class);
    }

    protected function getUserService() : SellerUserService
    {
        return app()->make(SellerUserService::class);
    }

    protected function getTransactionResolver() : TransactionResolver
    {
        return app()->make(TransactionResolver::class);
    }

    protected function getVerifyEmailRepository() : VerifyEmailRepository
    {
        return app()->make(VerifyEmailRepository::class);
    }

    public function getKey(): int
    {
        return $this->userId->getInt();
    }

    public function getUserId(): SellerId
    {
        return $this->userId;
    }

    public function getGoogleId(): ?GoogleId
    {
        return $this->googleId;
    }

    public function getEmailAddress(): ?EmailAddress
    {
        return $this->emailAddress;
    }

    public function isMigratedUser(): bool
    {
        return $this->migratedAt !== null;
    }

    public function getAuthIdentifierName()
    {
        return null;
    }

    public function getAuthIdentifier()
    {
        return $this->userId;
    }

    public function hasPassword(): bool
    {
        return $this->hashedPassword !== null;
    }

    public function getAuthPassword(): ?string
    {
        return $this->hashedPassword?->getString();
    }

    public function getHashedPassword(): ?HashedPassword
    {
        return $this->hashedPassword;
    }

    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function setRememberToken($value)
    {
        $this->rememberToken = $value;
    }

    public function getRememberTokenName()
    {
        return null;
    }

    public function sendPasswordResetNotification($token)
    {
//        $this->sendPasswordResetNotificationDefault($token);
        $this->notify(new PasswordResetNotification($token));
    }

    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedEmail(): bool
    {
        return $this->emailVerifiedAt !== null;
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified(): bool
    {
        $service = $this->getUserService();

        $data = $service->completeVerifyEmail(
            userId: $this->userId
        );
        $this->emailVerifiedAt = $data->emailVerifiedAt;
        $this->registrationCompletedAt = $data->registrationCompletedAt;
        $this->userData = $data;

        event(new Verified($this));

        return true;
    }

    public function forceUpdatePassword(Password $password)
    {
        $rep = $this->getUserRepository();
        $hashedPassword = $password->makeHashed();

        $rep->updatePassword($this->userId, $hashedPassword);
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification(): void
    {
        session()->put(SellerSessions::VERIFY_EMAIL_VERIFICATION_LINK_SENT_AT, CarbonImmutable::now());
        $this->notify(new VerifyEmailNotification());
    }

    /**
     * Get the email address that should be used for verification.
     *
     * @return string|null
     */
    public function getEmailForVerification(): ?string
    {
        return $this->emailAddress->getString();
    }

    public function getEmailForPasswordReset(): string
    {
        return $this->emailAddress->getString();
    }

    /**
     * Get the notification routing information for the mail driver.
     *
     * @param Notification|null $notification
     * @return mixed
     */
    protected function routeNotificationForMail(?Notification $notification = null): mixed
    {
        return $this->emailAddress->getString();
    }

    public function generateVerifyEmailData(): VerifyEmailData
    {
        return $this->getVerifyEmailRepository()->createVerifyEmail(
            group: VerifyEmailGroup::SellerUser,
            email: $this->getEmailAddress(),
            expiration: CarbonImmutable::now()->addMinutes(Config::get(AuthConfig::VERIFICATION_EXPIRE, 60))
        );
    }

    public function canPasswordLogin(): bool
    {
        if ($this->getEmailAddress() === null) {
            return false;
        }
        if (! $this->hasPassword()) {
            return false;
        }
        if ($this->registrationCompletedAt === null) {
            return false;
        }
        return true;
    }
}
