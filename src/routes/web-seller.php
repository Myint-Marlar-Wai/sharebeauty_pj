<?php

declare(strict_types=1);

use App\Auth\SellerAuth;
use App\Constants\Routes\SellerRateLimiters;
use App\Http\Controllers\Common\HealthCheckController;
use App\Http\Controllers\Seller\AjaxController;
use App\Http\Controllers\Seller\Auth\Guest\GoogleAuthController;
use App\Http\Controllers\Seller\Auth\Guest\LoginController;
use App\Http\Controllers\Seller\Auth\Guest\PasswordResetController;
use App\Http\Controllers\Seller\Auth\Guest\RegisteredUserController;
use App\Http\Controllers\Seller\Auth\Guest\VerifyEmailController;
use App\Http\Controllers\Seller\Auth\VerifyEmailForAuthController;
use App\Http\Controllers\Seller\ContactController;
use App\Http\Controllers\Seller\DummyController;
use App\Http\Controllers\Seller\HomeController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\SaleController;
use App\Http\Controllers\Seller\Setting\BankAccountController;
use App\Http\Controllers\Seller\Setting\OnceController;
use App\Http\Controllers\Seller\Setting\PasswordController;
use App\Http\Controllers\Seller\Setting\ProfileController;
use App\Http\Controllers\Seller\ShopController;
use App\Http\Routes\SellerRoutes;
use App\Http\Routes\Support\RouteUtil;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Seller Routes
| ショップ運営（利用者側、売り手側）
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ヘルスチェック用
Route::prefix('_health')->group(function () {
    Route::get('default', [HealthCheckController::class, 'default']);
});

// Dummy
Route::get('/_dummy', [DummyController::class, 'index']);

// ログイン系画面
// middleware guest ログインしている場合は、ログイン済み画面へ移動
Route::middleware(['guest:'.SellerAuth::GUARD_WEB])
    ->group(function () {
        // ユーザーログイン
        Route::get('login', [LoginController::class, 'getIndex'])
            ->name(SellerRoutes::LOGIN);
        Route::post('login/perform', [LoginController::class, 'postLoginPerform'])
            ->name(SellerRoutes::LOGIN_PERFORM);

        // ユーザー登録
        Route::get('register', [RegisteredUserController::class, 'getIndex'])
            ->name(SellerRoutes::REGISTER);
        Route::post('register/perform', [RegisteredUserController::class, 'postPerform'])
            ->middleware([
                'throttle:'.SellerRateLimiters::REGISTRATION,
            ])
            ->name(SellerRoutes::REGISTER_PERFORM);

        // Google ログイン
        Route::get('login/auth/google', [GoogleAuthController::class, 'getRedirectToGoogleForLogin'])
            ->name(SellerRoutes::AUTH_GOOGLE_FOR_LOGIN);
        Route::get('register/auth/google', [GoogleAuthController::class, 'getRedirectToGoogleForRegistration'])
            ->name(SellerRoutes::AUTH_GOOGLE_FOR_REGISTRATION);
        Route::get('auth/google/callback', [GoogleAuthController::class, 'getGoogleCallback'])
            ->name(SellerRoutes::AUTH_GOOGLE_CALLBACK);

        // パスワードリセット
        Route::prefix('reset-password')
            ->group(function () {
                // パスワードリセット開始画面表示
                Route::get('/', [PasswordResetController::class, 'getReset'])
                    ->name(SellerRoutes::PASSWORD_RESET_INDEX);
                // パスワードリセットリンクの送信
                Route::post('send-link', [PasswordResetController::class, 'postSendRestLink'])
                    ->name(SellerRoutes::PASSWORD_RESET_SEND_LINK);
                // パスワードリセットリンクの送信完了
                Route::get('send-link/completed', [PasswordResetController::class, 'getSendRestLinkCompleted'])
                    ->name(SellerRoutes::PASSWORD_RESET_SEND_LINK_COMPLETED);
                // パスワードリセットリンク
                Route::get('links/{token}', [PasswordResetController::class, 'getRestLink'])
                    ->middleware([
                        'signed',
                    ])
                    ->name(SellerRoutes::PASSWORD_RESET_LINK);
                // パスワードを設定する
                Route::post('update/perform', [PasswordResetController::class, 'postUpdatePerform'])
                    ->name(SellerRoutes::PASSWORD_RESET_UPDATE_PERFORM);
                // パスワードを設定完了
                Route::get('update/completed', [PasswordResetController::class, 'getUpdateCompleted'])
                    ->name(SellerRoutes::PASSWORD_RESET_UPDATE_COMPLETED);
            });

        RouteUtil::fallbackPage();
    });

// メール認証
Route::prefix('verify-email')
    ->group(function () {
        Route::middleware([
            'auth:'.SellerAuth::GUARD_WEB,
        ])->group(function () {
            // メール確認送信用画面(Auth)
            Route::get('/', [VerifyEmailForAuthController::class, 'getIndex'])
                ->name(SellerRoutes::VERIFICATION_NOTICE_INDEX);

            // 確認メールの送信
            Route::post('send/perform', [VerifyEmailForAuthController::class, 'postSendPerform'])
                ->middleware([
                    'throttle:'.SellerRateLimiters::VERIFY_EMAIL_SEND,
                ])
                ->name(SellerRoutes::VERIFICATION_SEND);
        });

        // メール確認送信用画面(Email)
        Route::get('guest', [VerifyEmailController::class, 'getIndexForGuest'])
            ->name(SellerRoutes::VERIFICATION_NOTICE_INDEX_EMAIL);

        // メール確認URL メールから遷移する
        // middleware signed 署名付き
        Route::get('verify/links/{token}', [VerifyEmailController::class, 'getVerifyLink'])
            ->middleware([
                'signed',
            ])
            ->name(SellerRoutes::VERIFICATION_VERIFY);

        // メール確認実行
        Route::post('verify/perform', [VerifyEmailController::class, 'postVerifyPerform'])
            ->middleware([
                'throttle:'.SellerRateLimiters::VERIFY_EMAIL_VERIFY,
            ])
            ->name(SellerRoutes::VERIFICATION_VERIFY_PERFORM);

        // 確認完了
        Route::get('verify/completed', [VerifyEmailController::class, 'getVerifyCompleted'])
            ->name(SellerRoutes::VERIFICATION_VERIFY_COMPLETED);

        RouteUtil::fallbackPage();
    });

// ログアウト
Route::post('logout/perform', [LoginController::class, 'postLogoutPerform'])
    ->name(SellerRoutes::LOGOUT_PERFORM);

// ログイン済みコンテンツ
// middleware auth ログイン済み
// middleware verified メール認証済み
Route::middleware(['auth:'.SellerAuth::GUARD_WEB, 'verified'])
    ->group(function () {
        // Home (To Shops)
        Route::get('/', [HomeController::class, 'getIndex'])
            ->name(SellerRoutes::HOME);
        // ショップ一覧
        Route::get('/shops', [ShopController::class, 'getShops'])
            ->name(SellerRoutes::SHOPS);
        // ショップ作成
        Route::get('/shops/create', [ShopController::class, 'create']);
        Route::post('/shops/store', [ShopController::class, 'store']);
        // 各ショップごと
        Route::prefix('shops/{'.SellerRoutes::PARAM_SHOP_ID.'}')
            ->middleware([])
            ->group(function () {
                Route::get('detail', [ShopController::class, 'getDetail'])
                    ->name(SellerRoutes::SHOP_DETAIL);
            });

        Route::get('/shop/publish/{id}', [ShopController::class, 'publish']);
        Route::post('/shop/publish/{id}', [ShopController::class, 'publishSetting']);
        Route::get('/shop/{shopId}/update', [ShopController::class, 'shopChange']);
        Route::post('/shop/{shopId}/update', [ShopController::class, 'shopChangeStore']);

        // 設定
        Route::prefix('setting')
            ->middleware([])
            ->group(function () {
                // 設定トップ
                Route::get('/', [OnceController::class, 'setting'])
                    ->name(SellerRoutes::SETTING);

                Route::get('once', [OnceController::class, 'index']);
                Route::post('once', [OnceController::class, 'store']);
                Route::get('complete', [OnceController::class, 'complete']);
                // パスワード変更
                Route::get('password', [PasswordController::class, 'getChange'])
                    ->name(SellerRoutes::PASSWORD_CHANGE);
                Route::post('password/perform', [PasswordController::class, 'postChangePerform'])
                    ->name(SellerRoutes::PASSWORD_CHANGE_PERFORM);
                Route::get('password/completed', [PasswordController::class, 'getChangeCompleted'])
                    ->name(SellerRoutes::PASSWORD_CHANGE_COMPLETED);

                Route::get('profile', [ProfileController::class, 'index']);
                Route::post('profile', [ProfileController::class, 'store']);

                Route::get('bank', [BankAccountController::class, 'index']);
                Route::post('bank', [BankAccountController::class, 'store']);
            });

        Route::get('/shops/sales', [DummyController::class, 'index'])
            ->name(SellerRoutes::SALES);

        Route::get('/once/{once_id}/sales', [SaleController::class, 'index']);
        Route::get('/shop/{shop_id}/sales', [SaleController::class, 'shopIndex']);

        Route::get('/order/{shop_id}', [OrderController::class, 'index']);

        RouteUtil::fallbackPage();
    });

//Route::get('/forgot-password', [PasswordController::class, 'index']);
//Route::post('/forgot-password', [PasswordController::class, 'emailSend']);
//Route::get('/reset-password/{token}', [PasswordController::class, 'create'])->name('password.reset');
//Route::get('/forgot-password/send', [PasswordController::class, 'send']);
//Route::post('/reset-password', [PasswordController::class, 'reset']);
//Route::get('/reset/password/compleate', [PasswordController::class, 'complete']);

Route::post('/disp-shop-name-check', [AjaxController::class, 'dispShopNameCheck']);
Route::post('/url-shop-id-check', [AjaxController::class, 'urlShopIdCheck']);
Route::post('/shop-sale-check', [AjaxController::class, 'shopSaleCheck']);
Route::post('/once-sale-check', [AjaxController::class, 'onceSaleCheck']);
Route::post('/once-order-check', [AjaxController::class, 'onceOrderCheck']);

Route::get('/terms', function () {
    return view('onceid.terms');
});
Route::get('/contact', [ContactController::class, 'index']);
Route::post('/contact', [ContactController::class, 'send']);

Route::post('/support', [DummyController::class, 'index'])
    ->name(SellerRoutes::SUPPORT);

// 全体にマッチしない場合
RouteUtil::fallbackPage();
