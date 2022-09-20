<?php

declare(strict_types=1);

namespace App\Services\Member;

use App\Data\Common\EmailAddress;
use App\Data\Common\Password;
use App\Data\Common\StrictPassword;
use App\Data\Member\MemberAuthData;
use App\Data\Member\MemberCreateData;
use App\Data\Member\MemberId;
use App\Exceptions\AppExceptions;
use App\Exceptions\Basic\AppMismatchCurrentPasswordException;
use App\Exceptions\Basic\AppNoPasswordOnPasswordChangeException;
use App\Exceptions\Basic\AppUserAlreadyExistsException;
use App\Repositories\Member\MemberRepository;
use App\Repositories\Support\TransactionResolver;
use App\Services\Base\BaseService;
use Carbon\CarbonImmutable;
use Throwable;

class MemberDefaultService extends BaseService implements MemberService
{
    public function __construct(
        public MemberRepository $userRepository,
        public TransactionResolver $transactionResolver,
    ) {
    }

    /**
     * @throws AppUserAlreadyExistsException
     */
    protected function handleExistingUserForCreate(?MemberId $existingUserId, bool $deleteTempUser) : void
    {
        if ($existingUserId === null) {
            return;
        }
        $existingUserData = $this->userRepository->getAuthData($existingUserId);
        if ($existingUserData->registrationCompletedAt !== null) {
            // 既存登録完了済みアカウント
            throw new AppUserAlreadyExistsException();
        }
        if ($deleteTempUser) {
            // 仮登録ユーザーの削除
            $this->userRepository->delete(userId: $existingUserId);
        }
    }

    public function createByEmail(
        EmailAddress $email,
        Password $password,
        MemberCreateData $data
    ): MemberAuthData {
        $ts = $this->transactionResolver->resolve([$this->userRepository]);
        $user = $ts->transaction(function () use ($email, $password, $data) {
            $this->userRepository->lockForUserCreate();
            // email 既存ユーザー
            $existingUserId = $this->userRepository->getIdByEmail(email: $email);
            $this->handleExistingUserForCreate($existingUserId, false);
            // 論理駆除の掃除
            $this->userRepository->cleanSoftDeleteByEmail(email: $email);

            $newDisplayMemberId = $this->userRepository->getNewDisplayMemberIdForUpdate();
            $userId = $this->userRepository->createByEmail(
                email: $email,
                hashedPassword: $password->makeHashed(),
                displayMemberId: $newDisplayMemberId,
                data: $data
            );

            return $this->userRepository->getAuthData($userId);
        });
        assert($user instanceof MemberAuthData);

        return $user;
    }

    /**
     * @throws Throwable
     */
    public function changePassword(
        MemberId $userId,
        Password $currentPassword,
        StrictPassword $newPassword
    ) {
        $ts = $this->transactionResolver->resolve([$this->userRepository]);
        $ts->transaction(function () use ($userId, $currentPassword, $newPassword) {
            $user = $this->userRepository->getAuthData($userId);
            if ($user === null) {
                throw AppExceptions::notFoundResource('user_id');
            }
            if ($user->hashedPassword === null) {
                throw new AppNoPasswordOnPasswordChangeException();
            }

            if (! $user->hashedPassword->matchWithPlain(plain: $currentPassword)) {
                throw new AppMismatchCurrentPasswordException();
            }
            $this->userRepository->updatePassword(
                userId: $userId,
                hashedPassword:  $newPassword->makeHashed(),
            );
        });
    }

    public function completeVerifyEmail(
        MemberId       $userId
    ) : MemberAuthData {
        $at = CarbonImmutable::now();
        $ts = $this->transactionResolver->resolve([$this->userRepository]);
        $user = $ts->transaction(function () use ($userId, $at) {
            $data = $this->userRepository->getAuthData($userId);
            $isRegistrationCompleted = $data->registrationCompletedAt !== null;
            $this->userRepository->markEmailVerified($userId, $at);
            if (! $isRegistrationCompleted) {
                $this->userRepository->markRegistrationCompleted($userId, $at);
            }

            return $this->userRepository->getAuthData($userId);
        });
        assert($user instanceof MemberAuthData);

        return $user;
    }
}
