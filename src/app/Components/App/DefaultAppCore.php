<?php

declare(strict_types=1);

namespace App\Components\App;

use App\Components\App\AppCore as AppCoreInterface;
use App\Constants\App\AppDataEnv;
use App\Constants\App\AppSystem;
use App\Constants\Configs\AppConfig;

class DefaultAppCore implements AppCoreInterface
{
    public function isDebug(): bool
    {
        return config(AppConfig::DEBUG);
    }

    public function getSystem(): AppSystem
    {
        return AppSystem::from(config(AppConfig::SYSTEM));
    }

    public function getDataEnv(): AppDataEnv
    {
        return AppDataEnv::from(config(AppConfig::DATA_ENV));
    }
}
