<?php

declare(strict_types=1);

namespace App\Providers;

use App\Auth\Models\SellerAuthUser;
use App\Auth\UserProviders\EmptyAuthUserProvider;
use App\Auth\UserProviders\ShopUserAuthUserProvider;
use App\Auth\UserProviders\SellerUserAuthUserProvider;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use App\Mail\SellerMailVerificationMail;
use Auth;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;
use Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Seller User
        Auth::provider(SellerUserAuthUserProvider::PROVIDER_NAME, function (Application $app, array $config): SellerUserAuthUserProvider {
            Log::debug('seller-auth-provider', ['config' => $config]);

            return $app->make(SellerUserAuthUserProvider::class);
        });

        //  Shop User (Member)
        Auth::provider(ShopUserAuthUserProvider::PROVIDER_NAME, function (Application $app, array $config): ShopUserAuthUserProvider {
            Log::debug('member-auth-provider', ['config' => $config]);

            return $app->make(ShopUserAuthUserProvider::class);
        });

        // Empty
        Auth::provider(EmptyAuthUserProvider::PROVIDER_NAME, function (Application $app, array $config): EmptyAuthUserProvider {
            return $app->make(EmptyAuthUserProvider::class);
        });
    }
}
