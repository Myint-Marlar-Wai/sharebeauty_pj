<?php

declare(strict_types=1);

use App\Http\Controllers\Demo\ApiDemoController;
use App\Http\Controllers\Demo\WebDemoController;
use App\Http\Routes\DemoRoutes;
use App\Http\Routes\Support\RouteUtil;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Demo Routes
| デモ
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('web')
    ->group(function () {
        Route::prefix('form/{'.DemoRoutes::PARAM_FORM_ID.'}')
            ->group(function () {
                Route::get('/', [WebDemoController::class, 'getForm'])
                    ->name(DemoRoutes::WEB_FORM);
                Route::post('update', [WebDemoController::class, 'postFormUpdate'])
                    ->name(DemoRoutes::WEB_FORM_UPDATE);
                Route::post('clear', [WebDemoController::class, 'postFormClear'])
                    ->name(DemoRoutes::WEB_FORM_CLEAR);
            });
        // demo web にマッチしない場合
        RouteUtil::fallbackPage();
    });

Route::prefix('api')
    ->middleware(['api-behavior'])
    ->group(function () {

        Route::prefix('form/{'.DemoRoutes::PARAM_FORM_ID.'}')
            ->group(function () {
                Route::get('/', [ApiDemoController::class, 'getForm'])
                    ->name(DemoRoutes::API_FORM);
                Route::post('update', [ApiDemoController::class, 'postFormUpdate'])
                    ->name(DemoRoutes::API_FORM_UPDATE);
                Route::post('clear', [ApiDemoController::class, 'postFormClear'])
                    ->name(DemoRoutes::API_FORM_CLEAR);
            });

        // demo api にマッチしない場合
        RouteUtil::fallbackEndpoint();
    });

// demo 全体にマッチしない場合
RouteUtil::fallbackPage();

