<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Batch Routes
| バッチ処理
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ヘルスチェック用
Route::prefix('_health')->group(function () {
    Route::get('default', [\App\Http\Controllers\Common\HealthCheckController::class, 'default']);
});

Route::get('/', [\App\Http\Controllers\Batch\TopController::class, 'index']);
