<?php

declare(strict_types=1);

namespace App\Services\SellerAuth;

use App\Data\Common\Password;
use App\Data\Common\StrictPassword;

/**
 * @deprecated not use
 */
interface SellerPasswordService extends \App\Services\Service
{
    public function changePassword(Password $currentPassword, StrictPassword $newPassword);
}
