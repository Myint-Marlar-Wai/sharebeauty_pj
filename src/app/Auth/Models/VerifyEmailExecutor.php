<?php

declare(strict_types=1);

namespace App\Auth\Models;

use App\Data\Auth\VerifyEmailData;
use App\Data\Common\EmailAddress;

interface VerifyEmailExecutor extends \Illuminate\Contracts\Auth\Authenticatable
{

    public function generateVerifyEmailData() : VerifyEmailData;
}
