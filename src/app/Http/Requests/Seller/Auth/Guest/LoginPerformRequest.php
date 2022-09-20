<?php

declare(strict_types=1);

namespace App\Http\Requests\Seller\Auth\Guest;

use App\Auth\SellerAuth;
use App\Data\Common\EmailAddress;
use App\Data\Common\LoosePassword;
use App\Data\Common\Password;
use App\Rules\EmailRule;
use App\Rules\PasswordRule;
use App\Rules\Support\PasswordType;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginPerformRequest extends FormRequest
{
    const PARAM_EMAIL = 'email';

    const PARAM_PASSWORD = 'password';

    const LANG_NAME = 'seller_login';

    const LANG_PREFIX = 'requests.'.self::LANG_NAME.'.';

    const LANG_AUTH_FAILED = self::LANG_PREFIX.'auth.failed';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            self::PARAM_EMAIL => ['required', 'string', new EmailRule()],
            self::PARAM_PASSWORD => ['required', 'string', new PasswordRule(PasswordType::Loose)],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function attemptAuthenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $guard = SellerAuth::guard();

        $credentials = [
            'email' => $this->getInputEmail(),
            'password' => $this->getInputPassword(),
        ];
        //$remember = $this->boolean('remember');
        if (! $guard->attempt($credentials, false)) {
            RateLimiter::hit($this->throttleKey(), 3600);

            throw ValidationException::withMessages([
                'email' => trans(self::LANG_AUTH_FAILED),
            ]);
        }
        //$this->session()->regenerate();

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle_in_minutes', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey(): string
    {
        return Str::lower($this->getInputEmail()->getString()).'|'.$this->ip();
    }

    public function getInputEmail() : EmailAddress
    {
        return EmailAddress::from($this->validated(self::PARAM_EMAIL));
    }

    public function getInputPassword() : Password
    {
        return LoosePassword::from($this->validated(self::PARAM_PASSWORD));
    }

//    public function ensureIsEmailVerified(): \Illuminate\Http\RedirectResponse|null
//    {
//        $user = OnceId::where('email', $this->input('email')->first());
//        if (! $user) {
//            throw ValidationException::withMessages([
//                'email' => trans(self::LANG_PREFIX.'auth.failed'),
//            ]);
//        }
//        $isVerified = $user->email_verified_at;
//        if (! $isVerified) {
//            return redirect('register');
//        }
//
//        return null;
//    }
}
