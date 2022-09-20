<?php

declare(strict_types=1);

namespace App\Services\Demo;

use App\Data\Demo\DemoFormId;
use App\Exceptions\Basic\AppNotFoundResourceException;
use App\Exceptions\Demo\AppDemoNeedsInputProfileException;

interface DemoFormService extends \App\Services\Service
{
    /**
     * @param DemoFormId $id
     * @return DemoFormShowOutput
     * @throws AppNotFoundResourceException|AppDemoNeedsInputProfileException
     */
    public function showForm(DemoFormId $id): DemoFormShowOutput;

    /**
     * @param DemoFormUpdateInput $input
     * @return DemoFormShowOutput
     * @throws AppNotFoundResourceException|AppDemoNeedsInputProfileException
     */
    public function updateForm(DemoFormUpdateInput $input): DemoFormShowOutput;

    /**
     * @param DemoFormId $id
     * @return DemoFormShowOutput
     * @throws AppNotFoundResourceException|AppDemoNeedsInputProfileException
     */
    public function clearForm(DemoFormId $id): DemoFormShowOutput;
}
