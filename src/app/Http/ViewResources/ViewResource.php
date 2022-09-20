<?php

declare(strict_types=1);

namespace App\Http\ViewResources;

use App\Components\View\PageInfo;
use Illuminate\Http\Request;
use Illuminate\Support\ViewErrorBag;

interface ViewResource
{
    public function getRequest() : Request;

    public function getPageInfo() :  PageInfo;

    public function errors() :  ViewErrorBag;

    public function getAlertErrorMessage() : ?string;

    public function getAlertSuccessMessage() : ?string;

}
