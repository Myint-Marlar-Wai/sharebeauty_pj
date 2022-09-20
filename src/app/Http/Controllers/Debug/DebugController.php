<?php


namespace App\Http\Controllers\Debug;

use App\Http\Controllers\Base\BaseController;
use Carbon\Carbon;
use Log;
use RuntimeException;

/**
 * デバッグ用コントローラー
 * 外部からアクセスされても問題ない内容のデバッグのみです。
 */
class DebugController extends BaseController
{
    /**
     * 内部エラーの動作確認用
     * @return string
     */
    public function error(): string
    {
        throw new RuntimeException('Test Error');
    }

    /**
     * 正常の動作確認用
     * @return string
     */
    public function success(): string
    {
        return 'Success';
    }

    /**
     * ログの動作確認用
     * @return string
     */
    public function log(): string
    {
        Log::info('Success Info Log '.Carbon::now()->toIso8601String());

        return 'Success';
    }

    /**
     * 時間、timezoneの動作確認用
     * @return string
     */
    public function datetime(): string
    {
        return Carbon::now()->toIso8601String();
    }
}
