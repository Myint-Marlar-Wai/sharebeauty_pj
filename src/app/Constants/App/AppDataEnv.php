<?php

declare(strict_types=1);

namespace App\Constants\App;

/*
 * アプリケーションのデータ環境種
 */
enum AppDataEnv: string
{
    /**
     * 本番
     */
    case Production = 'production';

    /**
     * 開発
     */
    case Development = 'development';

}
