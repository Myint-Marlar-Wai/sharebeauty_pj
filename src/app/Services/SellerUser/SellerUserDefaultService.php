<?php

declare(strict_types=1);

namespace App\Services\SellerUser;

use App\Auth\SellerAuth;
use App\Data\Common\EmailAddress;
use App\Data\Common\GoogleId;
use App\Data\Common\HashedPassword;
use App\Data\Common\Password;
use App\Data\Common\StrictPassword;
use App\Data\SellerUser\SellerAuthData;
use App\Data\SellerUser\SellerId;
use App\Exceptions\AppExceptions;
use App\Exceptions\Basic\AppMismatchCurrentPasswordException;
use App\Exceptions\Basic\AppNoPasswordOnPasswordChangeException;
use App\Exceptions\Basic\AppUserAlreadyExistsException;
use App\Repositories\SellerUser\SellerUserRepository;
use App\Repositories\Support\TransactionResolver;
use App\Services\Base\BaseService;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Events\Verified;
use Throwable;

class SellerUserDefaultService extends BaseService implements SellerUserService
{
    public function __construct(
        public SellerUserRepository $userRepository,
        public TransactionResolver $transactionResolver,
    ) {
    }

    /**
     * @throws AppUserAlreadyExistsException
     */
    protected function handleExistingUserForCreate(?SellerId $existingUserId, bool $deleteTempUser) : void
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

    /**
     * @throws Throwable
     */
    public function registerByEmail(
        EmailAddress $email,
        Password $password
    ): SellerAuthData {
        $ts = $this->transactionResolver->resolve([$this->userRepository]);
        $user = $ts->transaction(function () use ($email, $password) {
            $this->userRepository->lockForUserCreate();
            // email 既存ユーザー
            $existingUserId = $this->userRepository->getIdByEmail(email: $email);
            $this->handleExistingUserForCreate($existingUserId, false);
            // 論理駆除の掃除
            $this->userRepository->cleanSoftDeleteByEmail(email: $email);
            // 作成
            if ($existingUserId !== null) {
                // 仮登録ユーザのパスワード更新
                $userId = $existingUserId;
                $this->userRepository->updatePassword(
                    userId: $userId,
                    hashedPassword: $password->makeHashed(),
                );
            } else {
                // 仮登録新規作成
                $userId = $this->userRepository->createByEmail(
                    email: $email,
                    hashedPassword: $password->makeHashed(),
                );
            }

            return $this->userRepository->getAuthData($userId);
        });
        assert($user instanceof SellerAuthData);

        return $user;
    }

    /**
     * @throws Throwable
     */
    public function registerByGoogle(
        GoogleId $googleId,
        EmailAddress $email,
        bool $isEmailVerified
    ): SellerAuthData {
        $ts = $this->transactionResolver->resolve([$this->userRepository]);
        $now = CarbonImmutable::now();
        $user = $ts->transaction(function () use ($googleId, $email, $isEmailVerified, $now) {
            $this->userRepository->lockForUserCreate();
            // google 既存ユーザー
            $existingUserId = $this->userRepository->getIdByGoogleId(googleId: $googleId);
            $this->handleExistingUserForCreate($existingUserId, true);
            // email 既存ユーザー
            $existingUserId = $this->userRepository->getIdByEmail(email: $email);
            $this->handleExistingUserForCreate($existingUserId, true);

            // 論理駆除の掃除
            $this->userRepository->cleanSoftDeleteByGoogleId(googleId: $googleId);
            $this->userRepository->cleanSoftDeleteByEmail(email: $email);
            // 作成
            $userId = $this->userRepository->createByGoogle(
                googleId: $googleId,
                email: $email,
                emailVerifiedAt: $isEmailVerified ? $now : null
            );
            if ($isEmailVerified) {
                // 疎通確認済みメールの場合は、ユーザ登録完了とする
                $this->userRepository->markRegistrationCompleted(
                    userId: $userId,
                    completedAt: $now
                );
            }

            return $this->userRepository->getAuthData($userId);
        });
        assert($user instanceof SellerAuthData);

        return $user;
    }

    /**
     * @throws Throwable
     */
    public function changePassword(
        SellerId       $userId,
        Password       $currentPassword,
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
        SellerId       $userId
    ) : SellerAuthData {
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
        assert($user instanceof SellerAuthData);

        return $user;
    }
}
