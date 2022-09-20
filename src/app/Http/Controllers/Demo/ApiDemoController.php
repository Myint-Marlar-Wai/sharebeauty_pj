<?php

declare(strict_types=1);

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\Demo\DemoFormClearRequest;
use App\Http\Requests\Demo\DemoFormShowRequest;
use App\Http\Requests\Demo\DemoFormUpdateRequest;
use App\Http\Resources\Demo\DemoFormShowJsonResponse;
use App\Services\Demo\DemoFormDefaultService;
use App\Services\Demo\DemoFormService;

class ApiDemoController extends BaseController
{
    private DemoFormService $demoFormService;

    /**
     * @param DemoFormService $demoFormService
     */
    public function __construct(DemoFormService $demoFormService)
    {
        $this->demoFormService = $demoFormService;
    }

    public function getForm(DemoFormShowRequest $request): DemoFormShowJsonResponse
    {
        $demoFormId = $request->getDemoFormId();
        $output = $this->demoFormService->showForm($demoFormId);

        return DemoFormShowJsonResponse::makeByOutput($output);
    }

    public function postFormUpdate(DemoFormUpdateRequest $request): DemoFormShowJsonResponse
    {
        $input = $request->makeUpdateInput();
        $output = $this->demoFormService->updateForm($input);

        return DemoFormShowJsonResponse::makeByOutput($output);
    }

    public function postFormClear(DemoFormClearRequest $request): DemoFormShowJsonResponse
    {
        $demoFormId = $request->getDemoFormId();
        $output = $this->demoFormService->clearForm($demoFormId);

        return DemoFormShowJsonResponse::makeByOutput($output);
    }
}
