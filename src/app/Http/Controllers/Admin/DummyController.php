<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseController;


class DummyController extends BaseController
{

    public function index(): \Illuminate\Contracts\View\View
    {
        return view('admin.dummy');
    }


}
