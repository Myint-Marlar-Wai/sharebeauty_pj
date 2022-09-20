<?php

declare(strict_types=1);

namespace App\Services\Demo;

use App\Data\Demo\DemoFormAlphaData;
use App\Data\Demo\DemoFormBravoData;
use App\Data\Demo\DemoFormId;

class DemoFormUpdateInput
{
    public DemoFormId $id;

    public DemoFormAlphaData $alpha;

    public DemoFormBravoData $bravo;

    public static function makeWithId(DemoFormId $id): self
    {
        $instance = new self();
        $instance->id = $id;
        $instance->alpha = DemoFormAlphaData::makeWithId($id);
        $instance->bravo = DemoFormBravoData::makeWithId($id);

        return $instance;
    }
}
