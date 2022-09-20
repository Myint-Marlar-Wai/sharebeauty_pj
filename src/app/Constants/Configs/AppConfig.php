<?php
declare(strict_types=1);

namespace App\Constants\Configs;

/**
 * config() の キーの定数
 */
final class AppConfig
{
    private function __construct()
    {
    }

    /**
     * 環境名
     */
    const ENV = 'app.env';

    /**
     * 環境名
     */
    const DEBUG = 'app.debug';

    /**
     * システム環境名
     * コンフィグの値の例: shop, seller, admin, batch...
     */
    const SYSTEM = 'app.system';

    /**
     * データ環境名
     * コンフィグの値の例: production, development
     */
    const DATA_ENV = 'app.data_env';


}
