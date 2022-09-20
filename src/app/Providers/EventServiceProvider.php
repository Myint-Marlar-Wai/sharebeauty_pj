<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\LoginedAnotherIpAddress;
use App\Listeners\LoginFailed;
use App\Listeners\LoginSuccess;
use App\Listeners\SendLockOutMailToUser;
use App\Listeners\SendLoginedFromAnotherIpMail;
use Illuminate\Auth\Events\Failed as LaravelAuthFailed;
use Illuminate\Auth\Events\Lockout as LaravelAuthLockout;
use Illuminate\Auth\Events\Login as LaravelAuthLogin;
use Illuminate\Auth\Events\Registered as LaravelAuthRegistered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        LaravelAuthRegistered::class => [
            SendEmailVerificationNotification::class,
        ],
        LaravelAuthLogin::class => [
            LoginSuccess::class,
        ],
        LaravelAuthFailed::class => [
            LoginFailed::class,
        ],
        LaravelAuthLockout::class => [
            SendLockOutMailToUser::class,
        ],
        LoginedAnotherIpAddress::class => [
            SendLoginedFromAnotherIpMail::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
