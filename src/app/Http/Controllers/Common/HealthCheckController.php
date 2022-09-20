<?php


namespace App\Http\Controllers\Common;

use App\Http\Controllers\Base\BaseController;


class HealthCheckController extends BaseController
{

    /**
     * 正常の動作確認用
     * @return string
     */
    public function default(): string
    {
        return 'OK';
    }


}
