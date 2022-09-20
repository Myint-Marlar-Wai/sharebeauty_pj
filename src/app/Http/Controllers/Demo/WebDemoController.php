<?php

declare(strict_types=1);

namespace App\Http\Controllers\Demo;

use App\Constants\Sessions\DemoSessions;
use App\Constants\Views\DemoViews;
use App\Exceptions\Demo\AppDemoNeedsInputProfileException;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\Demo\DemoFormClearRequest;
use App\Http\Requests\Demo\DemoFormShowRequest;
use App\Http\Requests\Demo\DemoFormUpdateRequest;
use App\Http\Routes\DemoRoutes;
use App\Http\ViewResources\Demo\DemoFormViewResource;
use App\Services\Demo\DemoFormService;

class WebDemoController extends BaseController
{
    private DemoFormService $demoFormService;

    /**
     * @param DemoFormService $demoFormService
     */
    public function __construct(DemoFormService $demoFormService)
    {
        $this->demoFormService = $demoFormService;
    }

    public function getForm(DemoFormShowRequest $request): \Illuminate\Contracts\View\View
    {
        $demoFormId = $request->getDemoFormId();

        $output = $this->demoFormService->showForm($demoFormId);

        return view(DemoViews::FORM, [
            'vr' => DemoFormViewResource::make($request, $demoFormId, $output),
        ]);
    }

    public function postFormUpdate(DemoFormUpdateRequest $request): \Illuminate\Http\RedirectResponse
    {
        $demoFormId = $request->getDemoFormId();
        $input = $request->makeUpdateInput();
        try {
            $this->demoFormService->updateForm($input);
        } catch (AppDemoNeedsInputProfileException $ex) {
            // プロフィール入力未完了状態で更新を行った際に、特定の場所へ移動させるサンプル
            return to_route('login');
        }
        $elapsedSecFloat = (microtime(true) - LARAVEL_START);

        return redirect(DemoRoutes::urlDemoWebForm($demoFormId))
            ->with([
                DemoSessions::WEB_FORM_UPDATE_SUCCESS => sprintf('更新しました %.3f sec.', $elapsedSecFloat),
            ]);
    }

    public function postFormClear(DemoFormClearRequest $request): \Illuminate\Http\RedirectResponse
    {
        $demoFormId = $request->getDemoFormId();
        $this->demoFormService->clearForm($demoFormId);
        $elapsedSecFloat = (microtime(true) - LARAVEL_START);

        return redirect(DemoRoutes::urlDemoWebForm($demoFormId))
            ->with([
                DemoSessions::WEB_FORM_DELETE_SUCCESS => sprintf('削除しました %.4f sec.', $elapsedSecFloat),
            ]);
    }
}
