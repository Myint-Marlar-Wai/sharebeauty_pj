<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop\Auth\Guest;

use App\Auth\ShopAuth;
use App\Data\Common\Gender;
use App\Data\Member\MemberCreateData;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use App\Exceptions\Basic\AppUserAlreadyExistsException;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\Shop\Auth\Guest\RegistrationPerformRequest;
use App\Http\Routes\ShopRoutes;
use App\Http\ViewResources\Shop\Auth\RegistrationViewResource;
use App\Repositories\Auth\VerifyEmailRepository;
use App\Services\Member\MemberService;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegisteredUserController extends BaseController
{
    public function __construct(
        public MemberService $userService,
        public VerifyEmailRepository $verifyEmailRepository,
    ) {
    }

    public function getIndex(Request $request): View
    {
        return view('shop.auth.registration', [
            'vr' => RegistrationViewResource::make($request),
        ]);
    }

    /**
     * @param RegistrationPerformRequest $request
     * @return RedirectResponse
     */
    public function postPerform(RegistrationPerformRequest $request): RedirectResponse
    {
        $email = $request->getInputEmail();
        $password = $request->getInputPassword();

        $user = null;
        try {
            $createData = new MemberCreateData(
                firstName: '_firstName',
                firstNameKana: '_firstNameKana',
                lastName: '_lastName',
                lastNameKana: 'lastNameKana',
                zip: '1530042',
                prefCode: '13',
                address: '東京都目黒区青葉台３丁目',
                addressOther: '1-12イーストビル1階',
                tel: '0312341234',
                gender: Gender::Female,
                birthday: CarbonImmutable::createFromFormat('Y-m-d|', '1990-09-01'),
            );
            $user = $this->userService->createByEmail(
                email: $email,
                password: $password,
                data: $createData
            );
        } catch (AppUserAlreadyExistsException $ex) {
            // through
        }

        if ($user !== null) {
            // 作成できた場合のみ処理、ただしレスポンス
            $userProvider = ShopAuth::getUserProvider();
            $authUser = $userProvider->retrieveById($user->id);
            if (! $authUser) {
                throw AppExceptions::logicException(AppErrorCode::LOGIC_EXCEPTION_GENERAL);
            }

            ShopAuth::guard()->login($authUser);
            //$request->session()->regenerate();

            event(new Registered($authUser));

        } else {
            // TODO デバッグ用 メール送信
            $userProvider = ShopAuth::getUserProvider();
            $authUser = $userProvider->retrieveByCredentials(['email' => $email]);
            if (! $authUser) {
                throw AppExceptions::logicException(AppErrorCode::LOGIC_EXCEPTION_GENERAL);
            }

            //ShopAuth::guard()->login($authUser);
            //$request->session()->regenerate();

            //event(new Registered($authUser));
        }

        return ShopRoutes::toVerificationNoticeIndex();
    }

}
