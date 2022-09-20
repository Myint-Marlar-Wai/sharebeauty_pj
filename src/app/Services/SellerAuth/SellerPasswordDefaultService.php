<?php

namespace App\Services\SellerAuth;

use App\Data\Common\Password;
use App\Data\Common\StrictPassword;
use App\Services\Base\BaseService;

/**
 * @deprecated not use
 */
class SellerPasswordDefaultService extends BaseService implements SellerPasswordService
{
    public function changePassword(Password $currentPassword, StrictPassword $newPassword)
    {
        throw new \BadMethodCallException();
    }

}
