<?php

declare(strict_types=1);

namespace App\Auth\Models;

use App\Data\Common\EmailAddress;

interface HasEmailAuthUser extends \Illuminate\Contracts\Auth\Authenticatable
{

    public function getEmailAddress() : ?EmailAddress;
}
