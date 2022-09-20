<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop\Setting;

use App\Constants\Sessions\ShopSessions;
use App\Exceptions\Basic\AppMismatchCurrentPasswordException;
use App\Exceptions\Basic\AppNoPasswordOnPasswordChangeException;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\Shop\Auth\PasswordChangePerformRequest;
use App\Http\Requests\Shop\DefaultMemberRequest;
use App\Http\Routes\ShopRoutes;
use App\Http\ViewResources\Common\DefaultViewResource;
use App\Http\ViewResources\Shop\Auth\PasswordChangeViewResource;
use App\Services\Member\MemberService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PasswordController extends BaseController
{
    public function __construct(
        protected MemberService $userService
    ) {
    }

    /**
     * @throws AppNoPasswordOnPasswordChangeException
     */
    public function getChange(DefaultMemberRequest $request): View
    {
        $authUser = $request->getAuthUser();
        if (! $authUser->hasPassword()) {
            // パスワード変更できないログイン方法はエラー, たとえばgoogleログイン
            throw new AppNoPasswordOnPasswordChangeException();
        }

        return view('shop.auth.password-change', [
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

        return ShopRoutes::toPasswordChangeCompleted();
    }

    public function getChangeCompleted(Request $request): View
    {
        return view('shop.auth.password-change-completed', [
            'vr' => DefaultViewResource::make($request),
        ]);
    }
}
