<?php

declare(strict_types=1);

namespace App\Http\Controllers\Seller\Setting;

use App\Exceptions\Basic\AppMismatchCurrentPasswordException;
use App\Exceptions\Basic\AppNoPasswordOnPasswordChangeException;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\Seller\Auth\PasswordChangePerformRequest;
use App\Http\Requests\Seller\DefaultSellerUserRequest;
use App\Http\Routes\SellerRoutes;
use App\Http\ViewResources\Common\DefaultViewResource;
use App\Http\ViewResources\Seller\Auth\PasswordChangeViewResource;
use App\Services\SellerUser\SellerUserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PasswordController extends BaseController
{
    public function __construct(
        protected SellerUserService $userService,
    ) {
    }

    /**
     * @throws AppNoPasswordOnPasswordChangeException
     */
    public function getChange(DefaultSellerUserRequest $request): \Illuminate\Contracts\View\View
    {
        $authUser = $request->getAuthUser();
        if (! $authUser->hasPassword()) {
            // パスワード変更できないログイン方法はエラー, たとえばgoogleログイン
            throw new AppNoPasswordOnPasswordChangeException();
        }

        return view('seller.auth.password-change', [
            'vr' => PasswordChangeViewResource::make($request),
        ]);
    }

    /**
     * @throws AppNoPasswordOnPasswordChangeException
     * @throws ValidationException
     */
    public function postChangePerform(PasswordChangePerformRequest $request): RedirectResponse
    {
        $authUser = $request->getAuthUser();
        if (! $authUser->hasPassword()) {
            // パスワード変更できないログイン方法はエラー, たとえばgoogleログイン
            throw new AppNoPasswordOnPasswordChangeException();
        }

        $currentPassword = $request->getInputCurrentPassword();
        $newPassword = $request->getInputNewPassword();

        try {
            $this->userService->changePassword(
                userId: $authUser->getUserId(),
                currentPassword: $currentPassword,
                newPassword: $newPassword
            );
        } catch (AppMismatchCurrentPasswordException $e) {
            throw ValidationException::withMessages([
                PasswordChangePerformRequest::PARAM_CURRENT_PASSWORD => $e->resolveInfo()->message,
            ]);
        }

        return SellerRoutes::toPasswordChangeCompleted();
    }


    public function getChangeCompleted(Request $request): \Illuminate\Contracts\View\View
    {
        return view('seller.auth.password-change-completed', [
            'vr' => DefaultViewResource::make($request),
        ]);
    }

}
