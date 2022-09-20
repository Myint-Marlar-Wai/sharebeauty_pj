<?php

declare(strict_types=1);

namespace App\Repositories\UserLoginHistory;

use App\Data\Common\EmailAddress;
use App\Data\UserLoginHistory\UserLoginHistoryData;
use App\Models\UserLoginHistory;
use App\Repositories\Base\BaseRepository;

class UserLoginHistoryDefaultRepository extends BaseRepository implements UserLoginHistoryRepository
{
    public function create(UserLoginHistoryData $data)
    {
        UserLoginHistory::insert(
            [
                'login_attempt_at' => $data->attemptAt,
                'is_success' => $data->isSuccess,
                'email' => $data->email->getString(),
                'ip_address' => $data->ipAddress,
                'user_agent' => $data->userAgent,
            ]
        );
    }

    public function getLastIpaddressByEmail(EmailAddress $email): ?string
    {
        return UserLoginHistory::where('email', $email->getString())
            ->orderBy('login_attempt_at', 'desc')
            ->value('ip_address');
    }
}
