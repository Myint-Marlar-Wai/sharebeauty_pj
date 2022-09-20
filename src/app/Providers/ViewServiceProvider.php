<?php

namespace App\Providers;

use App\View\Composers\ViewResourceComposer;
use Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * 全アプリケーションサービスの登録
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * 全アプリケーションサービスの初期起動
     *
     * @return void
     */
    public function boot(): void
    {
        View::composer('*', ViewResourceComposer::class);

        Blade::anonymousComponentNamespace('shop.components', 'shop');
        Blade::anonymousComponentNamespace('seller.components', 'seller');
        Blade::anonymousComponentNamespace('admin.components', 'admin');
    }
}
