<?php

declare(strict_types=1);

namespace App\Http\Requests\Seller\Auth\Guest;

use App\Auth\Models\SellerAuthUser;
use App\Auth\SellerAuth;
use App\Data\Auth\VerifyEmailData;
use App\Data\Auth\VerifyEmailGroup;
use App\Data\Common\EmailAddress;
use App\Data\SellerUser\SellerId;
use App\Data\Support\Equatables;
use App\Repositories\Auth\VerifyEmailRepository;
use App\Rules\EmailRule;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\UnauthorizedException;
use Log;

class VerifyEmailVerifyPerformRequest extends FormRequest
{
    const PARAM_TOKEN = 'token';
    const PARAM_EMAIL = 'email';
    const LANG_NAME = 'seller_verify_email_verify_perform';
    const LANG_PREFIX = 'requests.'.self::LANG_NAME.'.';

    /**
     * authorize 実行時に代入される
     * @var VerifyEmailData|null
     */
    protected ?VerifyEmailData $verifyEmailData;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // まだバリデーション前なので直接取得
        $inputEmail = EmailAddress::tryFrom($this->input(self::PARAM_EMAIL));
        $inputTokenString = $this->input(self::PARAM_TOKEN);
        if ($inputTokenString === '') {
            $inputTokenString = null;
        }

        if ($inputEmail === null) {
            return false;
        }
        if ($inputTokenString === null) {
            return false;
        }

        $repository = $this->getVerifyEmailRepository();

        $verifyEmailData = $repository->getVerifyEmailByToken(
            VerifyEmailGroup::SellerUser, $inputTokenString);

        if ($verifyEmailData === null) {
            return false;
        }
        if (! Equatables::equals($verifyEmailData->email, $inputEmail)) {
            return false;
        }

        $this->verifyEmailData = $verifyEmailData;

        return true;
    }

    public function getVerifyEmailData() : VerifyEmailData
    {
        return $this->verifyEmailData;
    }

    /**
     * @throws AuthorizationException
     */
    public function getTargetAuthUserOrError() : SellerAuthUser
    {
        $data = $this->getVerifyEmailData();
        $authUser = SellerAuth::getUserProvider()->retrieveByCredentials([
            'email' => $data->email,
        ]);
        if ($authUser === null) {
            $this->failedAuthorization();
        }

        return $authUser;
    }

    public function getInputEmailAddress() : EmailAddress
    {
        return EmailAddress::from($this->validated(self::PARAM_EMAIL));
    }

    public function getInputToken() : string
    {
        return $this->validated(self::PARAM_TOKEN);
    }

    protected function getVerifyEmailRepository() : VerifyEmailRepository
    {
        return app()->make(VerifyEmailRepository::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            self::PARAM_TOKEN => ['required'],
            self::PARAM_EMAIL => ['required', new EmailRule()],
        ];
    }
}
