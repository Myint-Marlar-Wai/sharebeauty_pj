<?php

declare(strict_types=1);

namespace App\Services\Member;

use App\Data\Common\EmailAddress;
use App\Data\Common\Password;
use App\Data\Common\StrictPassword;
use App\Data\Member\MemberAuthData;
use App\Data\Member\MemberCreateData;
use App\Data\Member\MemberId;
use App\Exceptions\Basic\AppMismatchCurrentPasswordException;
use App\Exceptions\Basic\AppNoPasswordOnPasswordChangeException;
use App\Exceptions\Basic\AppUserAlreadyExistsException;
use Carbon\CarbonImmutable;

interface MemberService extends \App\Services\Service
{
    /**
     * @param EmailAddress $email
     * @param Password $password
     * @param MemberCreateData $data
     * @return MemberAuthData
     * @throws AppUserAlreadyExistsException
     */
    public function createByEmail(
        EmailAddress     $email,
        Password         $password,
        MemberCreateData $data
    ): MemberAuthData;

    /**
     * @param MemberId $userId
     * @param Password $currentPassword
     * @param StrictPassword $newPassword
     * @throws AppMismatchCurrentPasswordException
     * @throws AppNoPasswordOnPasswordChangeException
     */
    public function changePassword(
        MemberId       $userId,
        Password       $currentPassword,
        StrictPassword $newPassword
    );

    public function completeVerifyEmail(
        MemberId        $userId
    ) : MemberAuthData;
}
