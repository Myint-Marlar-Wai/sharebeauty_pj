<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Demo\DemoFormDefaultService;
use App\Services\Demo\DemoFormService;
use App\Services\Member\MemberDefaultService;
use App\Services\Member\MemberService;
use App\Services\SellerUser\SellerUserDefaultService;
use App\Services\SellerUser\SellerUserService;
use Illuminate\Contracts\Container\Container;

final class ServiceBootstrap
{
    public static function register(Container $ctr): void
    {
        $ctr->singleton(
            SlackNotificationServiceInterface::class,
            SlackNotificationService::class
        );
        $ctr->singleton(
            DemoFormService::class,
            DemoFormDefaultService::class
        );
        $ctr->singleton(
            SellerUserService::class,
            SellerUserDefaultService::class
        );
        $ctr->singleton(
            MemberService::class,
            MemberDefaultService::class
        );
    }

}
