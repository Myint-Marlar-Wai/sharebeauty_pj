<?php

declare(strict_types=1);

namespace App\Components\App;

use App\Constants\App\AppDataEnv;
use App\Constants\App\AppSystem;

interface AppCore
{
    public function isDebug(): bool;

    public function getSystem(): AppSystem;

    public function getDataEnv(): AppDataEnv;
}
