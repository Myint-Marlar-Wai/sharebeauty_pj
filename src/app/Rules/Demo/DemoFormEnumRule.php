<?php

declare(strict_types=1);

namespace App\Rules\Demo;

use App\Data\Demo\DemoFormEnum;
use App\Rules\Base\BaseEnumRule;

class DemoFormEnumRule extends BaseEnumRule
{

    const TYPE_NAME = DemoFormEnum::TYPE_NAME;

    public function __construct()
    {
        parent::__construct(DemoFormEnum::class);
    }

}
