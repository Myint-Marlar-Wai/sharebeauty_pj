<?php

declare(strict_types=1);

namespace App\Data\Demo;

use App\Data\Data;
use App\Data\Order\DisplayOrderId;

final class DemoFormBravoData implements Data
{
    public function __construct(
        public DemoFormId $id,
        public ?DisplayOrderId $displayOrderId,
        public ?DemoFormEnum $demoFormEnum
    ) {
    }

    public static function makeWithId(DemoFormId $id): self
    {
        return new self(
            id: $id,
            displayOrderId: null,
            demoFormEnum: null,
        );
    }
}
