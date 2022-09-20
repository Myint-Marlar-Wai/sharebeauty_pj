<?php

declare(strict_types=1);

namespace App\Http\Requests\Seller\Auth\Guest;

use App\Data\Common\EmailAddress;
use App\Data\Common\GoogleId;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use App\Http\Requests\Seller\Base\BaseSellerUserRequest;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Two\GoogleProvider;

class AuthGoogleCallbackRequest extends BaseSellerUserRequest
{
    //public const PARAM_APP_ACTION = 'app_action';

    public const APP_ACTION_LOGIN = 'login';

    public const APP_ACTION_REGISTRATION = 'registration';

    const LANG_NAME = 'seller_auth_google_callback';

    const LANG_PREFIX = 'requests.'.self::LANG_NAME.'.';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    protected \Laravel\Socialite\Two\User|\Laravel\Socialite\Contracts\User $googleUser;

    public function handleCallback(GoogleProvider $googleProvider): \Laravel\Socialite\Two\User|\Laravel\Socialite\Contracts\User|null
    {
        try {
            $googleUser = $googleProvider->user();
        } catch (\GuzzleHttp\Exception\ClientException $ex) {
            Log::info('auth-google-callback-error '.$ex->getMessage(), ['ex' => $ex]);
            throw AppExceptions::badRequest($ex->getMessage(), $ex);
        }
        Log::debug('google-login', ['user' => $googleUser]);
        $this->googleUser = $googleUser;

        return $googleUser;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [

        ];
    }

    public function getGoogleId() : GoogleId
    {
        return GoogleId::fromString($this->googleUser->getId());
    }

    public function getGoogleEmail(): EmailAddress
    {
        $googleEmail = EmailAddress::tryFromString($this->googleUser->getEmail());
        if (! ($googleEmail instanceof EmailAddress)) {
            throw AppExceptions::runtimeException(
                AppErrorCode::RUNTIME_EXCEPTION_ILLEGAL_GOOGLE_AUTH_EMAIL);
        }

        return $googleEmail;
    }

    public function isGoogleEmailVerified() : bool
    {
        $googleUser = $this->googleUser;
        $googleEmailVerified = filter_var(
            $googleUser->user['email_verified'],
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        );
        if (! is_bool($googleEmailVerified)) {
            throw AppExceptions::runtimeException(
                AppErrorCode::RUNTIME_EXCEPTION_ILLEGAL_GOOGLE_AUTH_EMAIL_VERIFIED_FLAG);
        }

        return $googleEmailVerified;
    }
}
