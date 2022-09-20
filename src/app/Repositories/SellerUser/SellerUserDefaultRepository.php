<?php

declare(strict_types=1);

namespace App\Repositories\SellerUser;

use App\Data\AdminUser\AdminUserId;
use App\Data\Common\EmailAddress;
use App\Data\Common\GoogleId;
use App\Data\Common\HashedPassword;
use App\Data\SellerUser\SellerAuthData;
use App\Data\SellerUser\SellerId;
use App\Models\Seller;
use App\Models\SellerPassword;
use App\Models\Support\DBToData as ToData;
use App\Repositories\Base\BaseRepository;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Log;
use Throwable;

class SellerUserDefaultRepository extends BaseRepository implements SellerUserRepository
{
    public function getAuthData(SellerId $userId): ?SellerAuthData
    {
        $u = Seller::def(as: null);
        $pw = SellerPassword::def(as: 'pw');
        Log::debug('SellerUserRepository.getAuthData');
        $row = Seller::leftJoin(
            $pw->getTable(), $pw->seller_id, '=', $u->id)
            ->where($u->id, '=', $userId->getInt())
            ->select([
                $u->id,
                $u->email,
                $u->email_verified_at,
                $u->google_id,
                $u->migrated_at,
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

        return new SellerAuthData(
            id: SellerId::fromNullable($row[$u->id]),
            email: EmailAddress::fromNullable($row[$u->email]),
            emailVerifiedAt: CarbonImmutable::make($row[$u->email_verified_at]),
            hashedPassword: HashedPassword::fromNullable($row[$pw->password]),
            googleId: GoogleId::fromNullable($row[$u->google_id]),
            migratedAt: CarbonImmutable::make($row[$u->migrated_at]),
            registrationCompletedAt: CarbonImmutable::make($row[$u->registration_completed_at]),
        );
    }

    public function getIdByEmail(EmailAddress $email): ?SellerId
    {
        $u = Seller::def(as: null);
        $value = Seller::where($u->email, '=', $email->getString())
            ->value($u->id);
        if ($value === null) {
            return null;
        }

        return SellerId::fromInt($value);
    }

    public function getIdByGoogleId(GoogleId $googleId): ?SellerId
    {
        $u = Seller::def(as: null);
        $value = Seller::where($u->google_id, '=', $googleId->getString())
            ->value($u->id);
        if ($value === null) {
            return null;
        }

        return SellerId::fromInt($value);
    }

    public function lockForUserCreate()
    {
        // TODO: Implement lockForUserCreate() method.
    }

    /**
     * @throws Throwable
     */
    public function createByEmail(
        EmailAddress $email,
        HashedPassword $hashedPassword
    ): SellerId {
        $opAdminUserId = $this->getOperationAdminUserId();
        $userId = null;
        DB::transaction(function () use ($email, $hashedPassword, $opAdminUserId, &$userId) {
            $u = Seller::def(as: null)->noname();
            $userIdInt = Seller::insertGetId([
                $u->email => $email->getString(),
                $u->last_modified_admin_id => $opAdminUserId->getInt(),
            ]);
            $pw = SellerPassword::def(as: 'pw')->noname();
            SellerPassword::insert([
                $pw->seller_id => $userIdInt,
                $pw->password => $hashedPassword->getString(),
            ]);
            $userId = SellerId::fromInt($userIdInt);
        });

        return $userId;
    }

    /**
     * @throws Throwable
     */
    public function createByGoogle(GoogleId $googleId, EmailAddress $email, ?CarbonImmutable $emailVerifiedAt): SellerId
    {
        $opAdminUserId = $this->getOperationAdminUserId();
        $userId = null;
        DB::transaction(function () use ($googleId, $email, $emailVerifiedAt, $opAdminUserId, &$userId) {
            $u = Seller::def(as: null)->noname();
            $userIdInt = Seller::insertGetId([
                $u->google_id => $googleId->getString(),
                $u->email => $email->getString(),
                $u->email_verified_at => $emailVerifiedAt,
                $u->last_modified_admin_id => $opAdminUserId->getInt(),
            ]);
            $userId = SellerId::fromInt($userIdInt);
        });

        return $userId;
    }

    /**
     * @throws Throwable
     */
    public function markEmailVerified(
        SellerId $userId,
        ?CarbonImmutable $verifiedAt
    ) {
        $opAdminUserId = $this->getOperationAdminUserId();
        $u = Seller::def(as: null)->noname();
        Seller::where($u->id, '=', $userId->getInt())
            ->update([
                $u->email_verified_at => $verifiedAt,
                $u->last_modified_admin_id => $opAdminUserId->getInt(),
            ]);
    }

    public function updatePassword(
        SellerId $userId,
        HashedPassword $hashedPassword,
    ) {
        $pw = SellerPassword::def(as: null)->noname();
        SellerPassword::updateOrInsert([
            $pw->seller_id =>  $userId->getInt(),
        ], [
            $pw->password => $hashedPassword->getString(),
        ]);
    }

    protected function getOperationAdminUserId() : AdminUserId
    {
        return AdminUserId::ofSystem();
    }

    public function markRegistrationCompleted(
        SellerId $userId,
        ?CarbonImmutable $completedAt
    ) {
        $opAdminUserId = $this->getOperationAdminUserId();
        $u = Seller::def(as: null)->noname();
        Seller::where($u->id, '=', $userId->getInt())
            ->update([
                $u->registration_completed_at => $completedAt,
                $u->last_modified_admin_id => $opAdminUserId->getInt(),
            ]);
    }

    public function cleanSoftDeleteByEmail(EmailAddress $email)
    {
        $u = Seller::def(as: null)->noname();
        Seller::onlyTrashed()
            ->where($u->email, '=', $email->getString())
        ->forceDelete();
    }

    public function cleanSoftDeleteByGoogleId(GoogleId $googleId)
    {
        $u = Seller::def(as: null)->noname();
        Seller::onlyTrashed()
            ->where($u->google_id, '=', $googleId->getString())
            ->forceDelete();
    }

    public function delete(SellerId $userId)
    {
        $u = Seller::def(as: null)->noname();
        Seller::where($u->id, '=', $userId->getInt())
            ->delete();
    }
}
