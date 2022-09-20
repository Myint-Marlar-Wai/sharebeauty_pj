<?php

declare(strict_types=1);

namespace App\Repositories\Demo;

use App\Data\Demo\DemoFormAlphaData;
use App\Data\Demo\DemoFormBravoData;
use App\Data\Demo\DemoFormId;

interface DemoFormRepository
{

    public function updateAlpha(DemoFormAlphaData $data);

    public function updateBravo(DemoFormBravoData $data);

    public function deleteAlpha(DemoFormId $id);

    public function deleteBravo(DemoFormId $id);

    public function getAlpha(DemoFormId $id): DemoFormAlphaData;

    public function getBravo(DemoFormId $id): DemoFormBravoData;

}
