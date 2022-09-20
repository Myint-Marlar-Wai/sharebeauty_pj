<?php

declare(strict_types=1);

namespace App\Repositories\Member;

use App\Data\Common\EmailAddress;
use App\Data\Common\HashedPassword;
use App\Data\Member\DisplayMemberId;
use App\Data\Member\MemberAuthData;
use App\Data\Member\MemberCreateData;
use App\Data\Member\MemberId;
use Carbon\CarbonImmutable;

interface MemberRepository
{
    public function getAuthData(
        MemberId $userId
    ): ?MemberAuthData;

    public function getIdByEmail(
        EmailAddress $email
    ): ?MemberId;

    public function lockForUserCreate();

    public function getNewDisplayMemberIdForUpdate(): ?DisplayMemberId;

    public function createByEmail(
        EmailAddress     $email,
        HashedPassword   $hashedPassword,
        DisplayMemberId  $displayMemberId,
        MemberCreateData $data,
    ): MemberId;

    public function updatePassword(
        MemberId       $userId,
        HashedPassword $hashedPassword,
    );

    public function markEmailVerified(
        MemberId         $userId,
        ?CarbonImmutable $verifiedAt
    );

    public function markRegistrationCompleted(
        MemberId         $userId,
        ?CarbonImmutable $completedAt,
    );

    public function cleanSoftDeleteByEmail(
        EmailAddress $email
    );

    public function delete(
        MemberId $userId,
    );

}
