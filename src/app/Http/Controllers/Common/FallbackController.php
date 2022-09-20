<?php


namespace App\Http\Controllers\Common;

use App\Http\Controllers\Base\BaseController;


class FallbackController extends BaseController
{

    /**
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function notFound(): void
    {
        abort(404);
    }


}
