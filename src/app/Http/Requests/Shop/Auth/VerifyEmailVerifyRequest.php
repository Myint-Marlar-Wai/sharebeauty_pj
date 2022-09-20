<?php

declare(strict_types=1);

namespace App\Http\Requests\Shop\Auth;

use App\Data\Member\MemberId;
use App\Data\Support\Equatables;
use App\Http\Requests\Shop\Base\BaseMemberRequest;
use Log;

class VerifyEmailVerifyRequest extends BaseMemberRequest
{
    const PARAM_TOKEN = 'token';

    const PARAM_EMAIL = 'email';

    const LANG_NAME = 'shop_member_verify_email_verify';

    const LANG_PREFIX = 'requests.'.self::LANG_NAME.'.';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {

        $inputId = $this->getMemberIdOrNull();
        $inputHash = (string) $this->route(self::PARAM_HASH);
        $authUser = $this->getAuthUser();

        if ($inputId === null) {
            return false;
        }

        if (! Equatables::equals($inputId, $authUser->getUserId())) {
            return false;
        }

        if (! hash_equals($inputHash,
            sha1($authUser->getEmailAddress()->getString()))) {
            return false;
        }

        return true;
    }

    public function getMemberIdOrNull() : ?MemberId
    {
        return MemberId::tryFromIntString(strval($this->route(self::PARAM_ID)));
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
