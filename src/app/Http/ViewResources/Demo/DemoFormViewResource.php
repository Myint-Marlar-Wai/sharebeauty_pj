<?php

declare(strict_types=1);

namespace App\Http\ViewResources\Demo;

use App\Constants\Sessions\DemoSessions;
use App\Data\Bank\BankAccountType;
use App\Data\Demo\DemoFormEnum;
use App\Data\Demo\DemoFormId;
use App\Http\Requests\Demo\DemoFormUpdateRequest;
use App\Http\Routes\DemoRoutes;
use App\Http\ViewResources\Base\BaseViewResource;
use App\Services\Demo\DemoFormShowOutput;
use Illuminate\Http\Request;
use Session;

class DemoFormViewResource extends BaseViewResource
{
    public DemoFormId $demoFormId;

    public string $input_bank_code;

    public string $input_account_type;

    public string $input_display_order_id;

    public string $input_demo_form_enum;

    public ?string $session_update_success_message = null;

    public ?string $session_delete_success_message = null;

    public function getUpdateActionUrl() : string
    {
        return DemoRoutes::urlDemoWebFormUpdate($this->demoFormId);
    }

    public function getClearActionUrl() : string
    {
        return DemoRoutes::urlDemoWebFormClear($this->demoFormId);
    }

    public function getDemoFormEnumList() : array
    {
        return array_merge(
            DemoFormEnum::getLangTextsByValue(),
            [
                'x' => '!! 不正な値 !!',
            ]
        );
    }

    public function getBankAccountTypeList() : array
    {
        return array_merge(
            BankAccountType::getLangTextsByValue(),
            [
                'x' => '!! 不正な値 !!',
            ]
        );
    }

    public function getElapsedMessage() : string
    {
        $elapsedSecFloat = (microtime(true) - LARAVEL_START);

        return sprintf('%.3f sec.', $elapsedSecFloat);
    }

    public function getApiDemoUActions() : array
    {
        return [
            'show' => ['GET', DemoRoutes::urlDemoApiForm($this->demoFormId)],
            'update' => ['POST', DemoRoutes::urlDemoApiFormUpdate($this->demoFormId)],
            'clear' => ['POST', DemoRoutes::urlDemoApiFormClear($this->demoFormId)],
        ];
    }

    public static function make(
        Request $request,
        DemoFormId $demoFormId,
        DemoFormShowOutput $output
    ) : self {
        $vd = new self($request);
        $vd->demoFormId = $demoFormId;

        // bravo
        $vd->input_display_order_id = old(DemoFormUpdateRequest::PARAM_DISPLAY_ORDER_ID, $output->bravo->displayOrderId?->getIntString()) ?? '';
        $vd->input_demo_form_enum = old(DemoFormUpdateRequest::PARAM_DEMO_FORM_ENUM, $output->bravo->demoFormEnum?->value) ?? '';

        // alpha
        $vd->input_bank_code = old(DemoFormUpdateRequest::PARAM_BANK_CODE, $output->alpha->bankCode?->getString()) ?? '';
        $vd->input_account_type = old(DemoFormUpdateRequest::PARAM_BANK_ACCOUNT_TYPE, $output->alpha->bankAccountType?->value) ?? '';

        $vd->session_update_success_message = Session::get(DemoSessions::WEB_FORM_UPDATE_SUCCESS);
        $vd->session_delete_success_message = Session::get(DemoSessions::WEB_FORM_DELETE_SUCCESS);

        return $vd;
    }

    public function getTitle() : string
    {
        return 'デモフォームID: '.$this->demoFormId->getIntString();
    }

    public function getDescription(): ?string
    {
        return 'デモ用のフォームサンプル';
    }

}
