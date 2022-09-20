<?php

declare(strict_types=1);

namespace App\Http\Controllers\Seller\Auth\Guest;

use App\Auth\SellerAuth;
use App\Constants\Configs\AuthConfig;
use App\Constants\Sessions\SellerSessions;
use App\Data\Auth\VerifyEmailData;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use App\Exceptions\Basic\AppUserAlreadyExistsException;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\Seller\Auth\Guest\RegistrationPerformRequest;
use App\Http\Routes\SellerRoutes;
use App\Http\ViewResources\Seller\Auth\RegistrationViewResource;
use App\Repositories\Auth\VerifyEmailRepository;
use App\Services\SellerUser\SellerUserService;
use App\Support\System;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class RegisteredUserController extends BaseController
{
    public function __construct(
        public SellerUserService $userService,
        public VerifyEmailRepository $verifyEmailRepository,
    ) {
    }

    public function getIndex(Request $request): View
    {
        return view('seller.auth.registration', [
            'vr' => RegistrationViewResource::make($request),
        ]);
    }

    /**
     * @param RegistrationPerformRequest $request
     * @return RedirectResponse
     */
    public function postPerform(RegistrationPerformRequest $request): RedirectResponse
    {
        $currentTime = microtime(true);
        $email = $request->getInputEmail();
        $password = $request->getInputPassword();

        $user = null;
        try {
            $user = $this->userService->registerByEmail(
                email: $email,
                password: $password,
            );
        } catch (AppUserAlreadyExistsException $ex) {
            // through
        }

        System::sleepUntil($currentTime + 2);

        $userProvider = SellerAuth::getUserProvider();

        if ($user !== null) {
            // 作成できた場合のみ処理、ただしレスポンス
            $authUser = $userProvider->retrieveById($user->id);
            if (! $authUser) {
                throw AppExceptions::logicException(AppErrorCode::LOGIC_EXCEPTION_GENERAL);
            }

            // 登録イベント（登録メール送信）
            event(new Registered($authUser));
        } else {
            // 既存登録済みユーザーへ通知
            $authUser = $userProvider->retrieveByCredentials(['email' => $email]);
            if (! $authUser) {
                throw AppExceptions::logicException(AppErrorCode::LOGIC_EXCEPTION_GENERAL);
            }

            // 登録イベント（登録メール送信） TODO
            event(new Registered($authUser));
        }

        $email = $authUser->getEmailAddress();
        $request->session()->put(SellerSessions::VERIFY_EMAIL_TARGET_EMAIL, $email);

        return SellerRoutes::toVerificationNoticeIndexWithEmail(
            email: $email
        );
    }
}
