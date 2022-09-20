<?php

declare(strict_types=1);

use App\Http\Controllers\Debug\DebugController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Debug Routes
| デバッグ
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// デバッグ用 外部からアクセスされても問題ない内容のデバッグのみ
Route::prefix('_debug')->group(function () {
    // 内部エラーの動作確認用
    Route::get('/error', [DebugController::class, 'error']);
    // 正常の動作確認用
    Route::get('/success', [DebugController::class, 'success']);
    // ログの動作確認用
    Route::get('/log', [DebugController::class, 'log']);
    // 時間、timezoneの動作確認用
    Route::get('/datetime', [DebugController::class, 'datetime']);
});
