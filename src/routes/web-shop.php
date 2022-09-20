<?php

declare(strict_types=1);

use App\Auth\ShopAuth;
use App\Constants\Routes\ShopRateLimiters;
use App\Http\Controllers\Shop\Auth\Guest\LoginController;
use App\Http\Controllers\Shop\Auth\Guest\PasswordResetController;
use App\Http\Controllers\Shop\Auth\Guest\RegisteredUserController;
use App\Http\Controllers\Shop\Auth\VerifyEmailController;
use App\Http\Controllers\Shop\DummyController;
use App\Http\Controllers\Shop\HomeController;
use App\Http\Controllers\Shop\Setting\PasswordController;
use App\Http\Routes\ShopRoutes;
use App\Http\Routes\Support\RouteUtil;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Shop Routes
| ショップ（ユーザー側、買い手側）
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
Route::get('/_dummy', [DummyController::class, 'index']);

// ログイン系画面
// middleware guest ログインしている場合は、ログイン済み画面へ移動
Route::middleware(['guest:'.ShopAuth::GUARD_WEB])
    ->group(function () {
        // ユーザーログイン
        Route::get('login', [LoginController::class, 'getIndex'])
            ->name(ShopRoutes::LOGIN);
        Route::post('login/perform', [LoginController::class, 'postLoginPerform'])
            ->name(ShopRoutes::LOGIN_PERFORM);

        // ユーザー登録
        Route::get('register', [RegisteredUserController::class, 'getIndex'])
            ->name(ShopRoutes::REGISTER);
        Route::post('register/perform', [RegisteredUserController::class, 'postPerform'])
            ->middleware([
                'throttle:'.ShopRateLimiters::REGISTRATION,
            ])
            ->name(ShopRoutes::REGISTER_PERFORM);

        // パスワードリセット
        Route::prefix('reset-password')
            ->group(function () {
                // パスワードリセット開始画面表示
                Route::get('/', [PasswordResetController::class, 'getReset'])
                    ->name(ShopRoutes::PASSWORD_RESET_INDEX);
                // パスワードリセットリンクの送信
                Route::post('send-link', [PasswordResetController::class, 'postSendRestLink'])
                    ->name(ShopRoutes::PASSWORD_RESET_SEND_LINK);
                // パスワードリセットリンクの送信完了
                Route::get('send-link/completed', [PasswordResetController::class, 'getSendRestLinkCompleted'])
                    ->name(ShopRoutes::PASSWORD_RESET_SEND_LINK_COMPLETED);
                // パスワードリセットリンク
                Route::get('links/{token}', [PasswordResetController::class, 'getRestLink'])
                    ->middleware([
                        'signed',
                    ])
                    ->name(ShopRoutes::PASSWORD_RESET_LINK);
                // パスワードを設定する
                Route::post('update/perform', [PasswordResetController::class, 'postUpdatePerform'])
                    ->name(ShopRoutes::PASSWORD_RESET_UPDATE_PERFORM);
                // パスワードを設定完了
                Route::get('update/completed', [PasswordResetController::class, 'getUpdateCompleted'])
                    ->name(ShopRoutes::PASSWORD_RESET_UPDATE_COMPLETED);
            });

        RouteUtil::fallbackPage();
    });


// ログアウト
Route::post('logout/perform', [LoginController::class, 'postLogoutPerform'])
    ->name(ShopRoutes::LOGOUT_PERFORM);


// メール認証
Route::prefix('verify-email')
    ->middleware(['auth:'.ShopAuth::GUARD_WEB])
    ->group(function () {
        // メール確認送信用画面
        Route::get('/', [VerifyEmailController::class, 'getPrompt'])
            ->name(ShopRoutes::VERIFICATION_NOTICE_INDEX);

        // 確認メールの送信
        Route::post('send', [VerifyEmailController::class, 'postSend'])
            ->middleware(['throttle:'.ShopRateLimiters::VERIFY_EMAIL_SEND])
            ->name(ShopRoutes::VERIFICATION_SEND);

        // メール確認URL メールから遷移する
        // middleware signed 署名付き
        Route::get('verify/{id}/{hash}', [VerifyEmailController::class, 'verifyEmail'])
            ->middleware([
                'signed',
                'throttle:'.ShopRateLimiters::VERIFY_EMAIL_VERIFY,
            ])
            ->name(ShopRoutes::VERIFICATION_VERIFY);

        // 確認完了
        Route::get('completed', [VerifyEmailController::class, 'getVerifyCompleted'])
            ->name(ShopRoutes::VERIFICATION_VERIFY_COMPLETED);

        RouteUtil::fallbackPage();
    });

// ログイン済みコンテンツ
// middleware auth ログイン済み
// middleware verified メール認証済み
Route::middleware(['auth:'.ShopAuth::GUARD_WEB, 'verified'])
    ->group(function () {
        // Home
        Route::get('/', [HomeController::class, 'getIndex'])
            ->name(ShopRoutes::HOME);

        // 会員情報
        Route::prefix('member')
            ->middleware([])
            ->group(function () {
                // 会員情報
                Route::get('/', [DummyController::class, 'index'])
                    ->name(ShopRoutes::MEMBER);
                // 配送先情報
                Route::get('shipping', [DummyController::class, 'index'])
                    ->name(ShopRoutes::MEMBER_SHIPPING);
            });


        // 設定
        Route::prefix('setting')
            ->middleware([])
            ->group(function () {
                // パスワード変更
                Route::get('password', [PasswordController::class, 'getChange'])
                    ->name(ShopRoutes::PASSWORD_CHANGE);
                Route::post('password/perform', [PasswordController::class, 'postChangePerform'])
                    ->name(ShopRoutes::PASSWORD_CHANGE_PERFORM);
                Route::get('password/completed', [PasswordController::class, 'getChangeCompleted'])
                    ->name(ShopRoutes::PASSWORD_CHANGE_COMPLETED);
            });

        RouteUtil::fallbackPage();
    });


// 全体にマッチしない場合
RouteUtil::fallbackPage();
