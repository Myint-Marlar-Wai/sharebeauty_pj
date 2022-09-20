<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Auth\Models\HasEmailAuthUser;
use App\Data\Common\EmailAddress;
use App\Data\UserLoginHistory\UserLoginHistoryData;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use App\Repositories\UserLoginHistory\UserLoginHistoryRepository;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Socialite\Two\User as SocialiteUser;
use Log;

class LoginFailed
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    protected function getLoginHistory() : UserLoginHistoryRepository
    {
        return app()->make(UserLoginHistoryRepository::class);
    }

    /**
     * Handle the event.
     *
     * @param Failed $event
     * @return void
     */
    public function handle(Failed $event): void
    {
        Log::debug('LoginFailed.handle', ['event' => $event]);
        $email = $this->getEmailAddress($event);
        if ($email !== null) {
            $this->getLoginHistory()->create(new UserLoginHistoryData(
                attemptAt: CarbonImmutable::now(),
                isSuccess: false,
                email: $email,
                ipAddress: request()->ip(),
                userAgent: request()->userAgent(),
            ));
        } else {
            // 不具合あり
            throw AppExceptions::logicException(AppErrorCode::LOGIC_EXCEPTION_NO_EMAIL_ON_LOGIN_EVENT);
        }
    }

    protected function getEmailAddress(Failed $event) : ?EmailAddress
    {
        $email = null;
        if (isset($event->credentials['email'])) {
            $email = $event->credentials['email'];
        } elseif (isset($event->credentials['google_user'])) {
            $googleUser = $event->credentials['google_user'];
            if ($googleUser instanceof SocialiteUser) {
                $email = $googleUser->getEmail();
            }
        }
        if ($email === null && $event->user instanceof HasEmailAuthUser) {
            $email = $event->user->getEmailAddress();
        }

        return EmailAddress::fromNullable($email);
    }
}
