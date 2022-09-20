<?php

declare(strict_types=1);

namespace App\Repositories\UserLoginHistory;

use App\Data\Common\EmailAddress;
use App\Data\UserLoginHistory\UserLoginHistoryData;

interface UserLoginHistoryRepository
{
    public function create(UserLoginHistoryData $data);
    public function getLastIpaddressByEmail(EmailAddress $email) : ?string;
}
