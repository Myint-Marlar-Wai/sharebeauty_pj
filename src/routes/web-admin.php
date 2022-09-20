<?php

declare(strict_types=1);

use App\Http\Routes\Support\RouteUtil;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Admin Routes
| 管理（会社）
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

// 仮のインデックスページ
// TODO 必要なくなったら削除
Route::get('/', [\App\Http\Controllers\Admin\DummyController::class, 'index']);
Route::get('/_dummy', [\App\Http\Controllers\Admin\DummyController::class, 'index']);

// 全体にマッチしない場合
RouteUtil::fallbackPage();
