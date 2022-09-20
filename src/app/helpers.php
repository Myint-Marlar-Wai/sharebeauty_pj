<?php
declare(strict_types=1);

use App\Components\App\AppCore;

/*
|--------------------------------------------------------------------------
| ヘルパー関数
|--------------------------------------------------------------------------
|
| ここには、汎用性や共通性が大きく、目的が一般的で、不変でシンプルな関数を記述します。
| 多くの場所で頻度多く利用し、呼び出す手間を小さくする場合に利用する。
|
| 以下で示すような関数をここに定義してはいけません。
| ・個別ユースケースのもの
| ・ビズネスロジックを含むもの
| ・プロジェクト毎に内容が変わるもの
|
| 以下で示すのが、許可される関数の例となる。
| ・アプリケーションがデバッグモードかどうかを返す
| ・システムのミリ秒で表される現在の時間を返す
|
*/


if (! function_exists('app_core')) {
    /**
     * デバッグモードの場合にtrue
     * @return AppCore
     */
    function app_core() : AppCore
    {
        return app(AppCore::class);
    }
}

if (! function_exists('app_debug')) {
    /**
     * デバッグモードの場合にtrue
     * @return bool
     */
    function app_debug() : bool
    {
        return app_core()->isDebug();
    }
}
