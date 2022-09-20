<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Auth\VerifyEmailCacheRepository;
use App\Repositories\Auth\VerifyEmailRepository;
use App\Repositories\Demo\DemoFormFileCacheRepository;
use App\Repositories\Demo\DemoFormRepository;
use App\Repositories\Member\MemberDefaultRepository;
use App\Repositories\Member\MemberRepository;
use App\Repositories\SellerUser\SellerUserDefaultRepository;
use App\Repositories\SellerUser\SellerUserRepository;
use App\Repositories\Support\TransactionDefaultResolver;
use App\Repositories\Support\TransactionResolver;
use App\Repositories\UserLoginHistory\UserLoginHistoryDefaultRepository;
use App\Repositories\UserLoginHistory\UserLoginHistoryRepository;
use Illuminate\Contracts\Container\Container;

final class RepositoryBootstrap
{
    public static function register(Container $ctr): void
    {
        $ctr->singleton(
            TransactionResolver::class,
            TransactionDefaultResolver::class
        );
        $ctr->singleton(
            DemoFormRepository::class,
            DemoFormFileCacheRepository::class
        );
        $ctr->singleton(
            SellerUserRepository::class,
            SellerUserDefaultRepository::class
        );
        $ctr->singleton(
            VerifyEmailRepository::class,
            VerifyEmailCacheRepository::class
        );
        $ctr->singleton(
            UserLoginHistoryRepository::class,
            UserLoginHistoryDefaultRepository::class
        );
        $ctr->singleton(
            MemberRepository::class,
            MemberDefaultRepository::class
        );
    }

}
