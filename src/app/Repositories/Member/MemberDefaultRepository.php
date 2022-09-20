<?php

declare(strict_types=1);

namespace App\Repositories\Member;

use App\Data\AdminUser\AdminUserId;
use App\Data\Common\EmailAddress;
use App\Data\Common\HashedPassword;
use App\Data\Member\DisplayMemberId;
use App\Data\Member\MemberAuthData;
use App\Data\Member\MemberCreateData;
use App\Data\Member\MemberId;
use App\Models\Member;
use App\Models\MemberPassword;
use App\Models\MemberProfile;
use App\Repositories\Base\BaseRepository;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Log;
use Throwable;

class MemberDefaultRepository extends BaseRepository implements MemberRepository
{
    public function getAuthData(MemberId $userId): ?MemberAuthData
    {
        $u = Member::def(null);
        $pw = MemberPassword::def('pw');
        Log::debug('MemberRepository.getAuthData');
        $row = Member::leftJoin($pw->getTable(), $pw->member_id, '=', $u->id)
            ->where($u->id, '=', $userId->getInt())
            ->select([
                $u->id,
                $u->email,
                $u->email_verified_at,
                $u->purchased_at,
                $u->registration_completed_at,
                $pw->password,
            ])
            ->first();
        if ($row === null) {
            return null;
        }
        // 未定義カラムをエラーにしたいため
        $row = $row->toArray();

        $u->noname();
        $pw->noname();

        return new MemberAuthData(
            id: MemberId::fromNullable($row[$u->id]),
            email: EmailAddress::fromNullable($row[$u->email]),
            emailVerifiedAt: CarbonImmutable::make($row[$u->email_verified_at]),
            hashedPassword: HashedPassword::fromNullable($row[$pw->password]),
            purchasedAt: CarbonImmutable::make($row[$u->purchased_at]),
            registrationCompletedAt: CarbonImmutable::make($row[$u->registration_completed_at]),
        );
    }

    public function getIdByEmail(EmailAddress $email): ?MemberId
    {
        $u = Member::def(null);
        $value = Member::where($u->email, '=', $email->getString())
            ->value($u->id);
        if ($value === null) {
            return null;
        }

        return MemberId::fromInt($value);
    }

    public function lockForUserCreate()
    {
        // TODO: Implement lockForUserCreate() method.
    }

    public function getNewDisplayMemberIdForUpdate(): ?DisplayMemberId
    {
        // TODO ロック用テーブル使う
        $u = Member::def(null);
        $value = Member::max($u->display_member_id);
        Log::debug('max', ['max' => $value]);
        if ($value !== null) {
            $value = DisplayMemberId::fromInt($value);
            $value = DisplayMemberId::makeWithIncr($value->getIncrementInt() + 1);
        } else {
            $value = DisplayMemberId::makeWithIncr(0);
        }

        return $value;
    }

    protected function getOperationAdminUserId() : AdminUserId
    {
        return AdminUserId::ofSystem();
    }

    public function createByEmail(
        EmailAddress $email,
        HashedPassword $hashedPassword,
        DisplayMemberId $displayMemberId,
        MemberCreateData $data,
    ) : MemberId {
        $userIdInt = null;
        $opAdminUserId = $this->getOperationAdminUserId();
        DB::transaction(function () use (
            $data,
            $email,
            $hashedPassword,
            $displayMemberId,
            $opAdminUserId,
            &$userIdInt
        ) {
            $u = Member::def(null)->noname();
            $up = MemberProfile::def(null)->noname();
            $pw = MemberPassword::def(null)->noname();

            $userIdInt = Member::insertGetId([
                $u->display_member_id => $displayMemberId->getInt(),
                $u->email => $email->getString(),
                $u->email_verified_at => null,
                $u->purchased_at => null,
                $u->last_modified_admin_id => $opAdminUserId->getInt(),
            ]);

            // プロフィール
            MemberProfile::insertGetId([
                $up->member_id => $userIdInt,
                $up->first_name => $data->firstName,
                $up->first_name_kana => $data->firstNameKana,
                $up->last_name => $data->lastName,
                $up->last_name_kana => $data->lastNameKana,
                $up->zip => $data->zip,
                $up->pref_code => $data->prefCode,
                $up->address => $data->address,
                $up->address_other => $data->addressOther,
                $up->tel => $data->tel,
                $up->gender => $data->gender,
                $up->birthday => $data->birthday,
                $up->last_modified_admin_id => $opAdminUserId->getInt(),
            ]);

            // パスワード
            MemberPassword::insert([
                $pw->member_id => $userIdInt,
                $pw->password => $hashedPassword->getString(),
            ]);
        });

        return MemberId::fromInt($userIdInt);
    }

    /**
     * @throws Throwable
     */
    public function markEmailVerified(
        MemberId $userId,
        ?CarbonImmutable $verifiedAt
    ) {
        $opAdminUserId = $this->getOperationAdminUserId();
        $u = Member::def(null)->noname();
        Member::where($u->id, '=', $userId->getInt())
            ->update([
                $u->email_verified_at => $verifiedAt,
                $u->last_modified_admin_id => $opAdminUserId->getInt(),
            ]);
    }

    public function updatePassword(
        MemberId $userId,
        HashedPassword $hashedPassword,
    ) {
        $pw = MemberPassword::def(null)->noname();
        MemberPassword::where($pw->member_id, '=', $userId->getInt())
            ->update([
                $pw->password => $hashedPassword->getString(),
            ]);
    }

    public function markRegistrationCompleted(MemberId $userId, ?CarbonImmutable $completedAt)
    {
        $opAdminUserId = $this->getOperationAdminUserId();
        $u = Member::def(as: null)->noname();
        Member::where($u->id, '=', $userId->getInt())
            ->update([
                $u->registration_completed_at => $completedAt,
                $u->last_modified_admin_id => $opAdminUserId->getInt(),
            ]);
    }

    public function cleanSoftDeleteByEmail(EmailAddress $email)
    {
        $u = Member::def(as: null)->noname();
        Member::onlyTrashed()
            ->where($u->email, '=', $email->getString())
            ->forceDelete();
    }

    public function delete(MemberId $userId)
    {
        $u = Member::def(as: null)->noname();
        Member::where($u->id, '=', $userId->getInt())
            ->delete();
    }
}
