<?php

declare(strict_types=1);

namespace App\Http\Resources\Demo;

use App\Http\Resources\Base\BaseAppJsonResponse;
use App\Services\Demo\DemoFormShowOutput;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JsonSerializable;

class DemoFormShowJsonResponse extends BaseAppJsonResponse
{
    public DemoFormShowOutput $output;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        $alpha = $this->output->alpha;
        $bravo = $this->output->bravo;
        return [
            'bank_code' => $alpha->bankCode?->getString(),
            'bank_account_type' => $alpha->bankAccountType?->value,
            'display_order_id' => $bravo->displayOrderId?->getInt(),
            'demo_form_enum' => $bravo->demoFormEnum?->value,
        ];
    }

    public static function makeByOutput(DemoFormShowOutput $output): static
    {
        $ret = new self(null);
        $ret->output = $output;
        return $ret;
    }
}
