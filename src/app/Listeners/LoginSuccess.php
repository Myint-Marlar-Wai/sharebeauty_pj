<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Auth\Models\HasEmailAuthUser;
use App\Data\Common\EmailAddress;
use App\Data\UserLoginHistory\UserLoginHistoryData;
use App\Events\LoginedAnotherIpAddress;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use App\Repositories\UserLoginHistory\UserLoginHistoryRepository;
use App\Services\SlackNotificationServiceInterface;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class LoginSuccess
{
    private SlackNotificationServiceInterface $slackNotification;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SlackNotificationServiceInterface $slackNotification)
    {
        $this->slackNotification = $slackNotification;
    }

    protected function getLoginHistory() : UserLoginHistoryRepository
    {
        return app()->make(UserLoginHistoryRepository::class);
    }

    /**
     * Handle the event.
     *
     * @param Login $event
     * @return void
     */
    public function handle(Login $event): void
    {
        Log::debug('LoginSuccess.handle', ['event' => $event, 'user' => get_debug_type($event->user)]);
        $this->checkIpAddress($event);
        $email = $this->getEmailAddress($event);
        Log::debug('LoginSuccess.handle 2', ['email' => $email]);
        if ($email !== null) {
            $this->getLoginHistory()->create(new UserLoginHistoryData(
                attemptAt: CarbonImmutable::now(),
                isSuccess: true,
                email: $email,
                ipAddress: request()->ip(),
                userAgent: request()->userAgent(),
            ));
        } else {
            // 不具合あり
            throw AppExceptions::logicException(AppErrorCode::LOGIC_EXCEPTION_NO_EMAIL_ON_LOGIN_EVENT);
        }
        $this->slackNotification->send('ログインがありました');
    }

    protected function getEmailAddress(Login $event) : ?EmailAddress
    {
        $email = null;
        if ($event->user instanceof HasEmailAuthUser) {
            $email = $event->user->getEmailAddress();
        }

        return EmailAddress::fromNullable($email);
    }

    public function checkIpAddress(Login $event): void
    {
        $email = $this->getEmailAddress($event);
        if ($email === null) {
            return;
        }

        $lastLoginIp = $this->getLoginHistory()->getLastIpaddressByEmail($email);

        $currentIp = request()->ip();

        if ($lastLoginIp !== null && $lastLoginIp !== $currentIp) {
            event(new LoginedAnotherIpAddress(request()));
        }
    }
}
