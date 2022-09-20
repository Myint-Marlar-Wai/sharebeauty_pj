<?php

declare(strict_types=1);

namespace App\Auth\Models;

use App\Data\Common\EmailAddress;

interface HasPrimaryKeyAuthUser extends \Illuminate\Contracts\Auth\Authenticatable
{

    public function getKey() : int;
}
