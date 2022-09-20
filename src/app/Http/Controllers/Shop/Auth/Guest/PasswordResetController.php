<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop\Auth\Guest;

use App\Auth\Models\ShopAuthUser;
use App\Auth\ShopAuth;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\Shop\Auth\Guest\PasswordResetSendLinkRequest;
use App\Http\Requests\Shop\Auth\Guest\PasswordResetUpdatePerformRequest;
use App\Http\Routes\ShopRoutes;
use App\Http\ViewResources\Common\DefaultViewResource;
use App\Http\ViewResources\Shop\Auth\PasswordResetViewResource;
use App\Http\ViewResources\Shop\Auth\PasswordUpdateViewResource;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetController extends BaseController
{

    /**
     * Display the password reset link request view.
     *
     * @param Request $request
     * @return View
     */
    public function getReset(Request $request): View
    {
        return view('shop.auth.password-reset', [
            'vr' => PasswordResetViewResource::make($request),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param PasswordResetSendLinkRequest $request
     * @return RedirectResponse
     */
    public function postSendRestLink(PasswordResetSendLinkRequest $request): RedirectResponse
    {
        $email = $request->getInputEmail();

        $broker = ShopAuth::passwordBroker();
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = $broker->sendResetLink([
            'email' => $email->getString(),
        ]);

        if ($status == Password::INVALID_USER) {
            // ユーザーが見つからない状態を、トークンの無効と表現する
            $status = Password::INVALID_TOKEN;
        }

        if ($status == Password::RESET_LINK_SENT) {
            return ShopRoutes::toPasswordResetSendLinkCompleted();
        } else {
            return back()->withInput($request->only(PasswordResetSendLinkRequest::PARAM_EMAIL))
                ->withErrors([PasswordResetSendLinkRequest::PARAM_EMAIL => __($status)]);
        }
    }

    /**
     * リセットリンク送信完了ページ
     * @param Request $request
     * @return View
     */
    public function getSendRestLinkCompleted(Request $request): View
    {
        return view('shop.auth.password-reset-completed', [
            'vr' => DefaultViewResource::make($request),
        ]);
    }

    /**
     * Display the password reset view.
     *
     * @param Request $request
     * @return View
     */
    public function getRestLink(Request $request): View
    {
        return view('shop.auth.password-update', [
            'vr' => PasswordUpdateViewResource::make($request),
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param PasswordResetUpdatePerformRequest $request
     * @return RedirectResponse
     */
    public function postUpdatePerform(PasswordResetUpdatePerformRequest $request): RedirectResponse
    {
        $broker = ShopAuth::passwordBroker();
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = $broker->reset(
            [
                'email' => $request->getInputEmail(),
                'password' => $request->getInputNewPassword(),
                'token' => $request->getInputToken(),
            ],
            function (ShopAuthUser $user, \App\Data\Common\Password $password) {
                $user->forceUpdatePassword(password: $password);
                if (! $user->hasVerifiedEmail()) {
                    // メールからリセットを行ったので、メール疎通確認済み
                    $user->markEmailAsVerified();
                }

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::INVALID_USER) {
            // ユーザーが見つからない状態を、トークンの無効と表現する
            $status = Password::INVALID_TOKEN;
        }

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status == Password::PASSWORD_RESET) {
            return ShopRoutes::toPasswordResetUpdateCompleted();
        } else {
            return back()->withInput($request->only(PasswordResetUpdatePerformRequest::PARAM_EMAIL))
                ->withErrors([PasswordResetUpdatePerformRequest::PARAM_EMAIL => __($status)]);
        }
    }

    /**
     * パスワード更新完了ページ
     *
     * @param Request $request
     * @return View
     */
    public function getUpdateCompleted(Request $request): View
    {
        return view('shop.auth.password-update-completed', [
            'vr' => DefaultViewResource::make($request),
        ]);
    }
}
