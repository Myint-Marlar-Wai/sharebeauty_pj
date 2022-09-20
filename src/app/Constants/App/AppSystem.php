<?php
declare(strict_types=1);

namespace App\Constants\App;

/**
 * アプリケーションのシステム環境種
 */
enum AppSystem: string
{
    /**
     * ショップ（ユーザー側、買い手側）
     */
    case Shop = 'shop';

    /**
     * ショップ運営（利用者側、売り手側）
     */
    case Seller = 'seller';

    /**
     * 管理（会社）
     */
    case Admin = 'admin';

    /**
     * バッチ処理
     */
    case Batch = 'batch';


}
