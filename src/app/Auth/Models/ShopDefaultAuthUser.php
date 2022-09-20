<?php

declare(strict_types=1);

namespace App\Auth\Models;

use App\Constants\Sessions\ShopSessions;
use App\Data\Common\EmailAddress;
use App\Data\Common\HashedPassword;
use App\Data\Common\Password;
use App\Data\Member\MemberAuthData;
use App\Data\Member\MemberId;
use App\Notifications\PasswordResetNotification;
use App\Notifications\VerifyEmailNotification;
use App\Repositories\Member\MemberRepository;
use App\Repositories\Support\TransactionResolver;
use App\Services\Member\MemberService;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class ShopDefaultAuthUser implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, ShopAuthUser /* MustVerifyEmailContract */
{
    use Authorizable, Notifiable, CanResetPassword, MustVerifyEmailTrait {
        CanResetPassword::sendPasswordResetNotification as sendPasswordResetNotificationDefault;
    }

    protected MemberId $userId;

    protected EmailAddress $emailAddress;

    protected ?CarbonImmutable $emailVerifiedAt = null;

    protected ?HashedPassword $hashedPassword = null;

    protected ?CarbonImmutable $purchasedAt;

    protected ?CarbonImmutable $registrationCompletedAt;

    protected ?string $rememberToken = null;

    /**
     * 認証ユーザーからソースデータを扱いたい場合用
     * @var MemberAuthData|null
     */
    protected ?MemberAuthData $userData = null;

    /**
     * @param MemberId $userId
     * @param EmailAddress $email
     * @param CarbonImmutable|null $emailVerifiedAt
     * @param HashedPassword|null $hashedPassword
     * @param CarbonImmutable|null $purchasedAt
     * @param CarbonImmutable|null $registrationCompletedAt
     * @param string|null $rememberToken
     * @param MemberAuthData|null $userData
     */
    public function __construct(
        MemberId $userId,
        EmailAddress $email,
        ?CarbonImmutable $emailVerifiedAt,
        ?HashedPassword $hashedPassword,
        ?CarbonImmutable $purchasedAt,
        ?CarbonImmutable $registrationCompletedAt,
        ?string $rememberToken,
        ?MemberAuthData $userData
    ) {
        $this->userId = $userId;
        $this->emailAddress = $email;
        $this->emailVerifiedAt = $emailVerifiedAt;
        $this->hashedPassword = $hashedPassword;
        $this->purchasedAt = $purchasedAt;
        $this->registrationCompletedAt = $registrationCompletedAt;
        $this->rememberToken = $rememberToken;
        $this->userData = $userData;
    }

    protected function getUserRepository(): MemberRepository
    {
        return app()->make(MemberRepository::class);
    }

    protected function getUserService(): MemberService
    {
        return app()->make(MemberService::class);
    }

    protected function getTransactionResolver() : TransactionResolver
    {
        return app()->make(TransactionResolver::class);
    }

    public function getKey(): int
    {
        return $this->userId->getInt();
    }

    public function getUserId(): MemberId
    {
        return $this->userId;
    }

    public function getEmailAddress(): ?EmailAddress
    {
        return $this->emailAddress;
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
        //$this->sendPasswordResetNotificationDefault($token);
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
        session()->put(ShopSessions::VERIFY_EMAIL_VERIFICATION_LINK_SENT_AT, CarbonImmutable::now());
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

    public function isPurchasedUser(): bool
    {
        return $this->purchasedAt !== null;
    }

    public function canPasswordLogin(): bool
    {
        // メール本人確認しているか、もしくは購入済みユーザー
        // そしてパスワードがある
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
