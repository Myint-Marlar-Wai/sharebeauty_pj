<?php

declare(strict_types=1);

namespace App\Data\Common;

use App\Data\Base\GetLangTextInterface;
use App\Data\Base\GetLangTextTrait;

enum Gender: string implements GetLangTextInterface
{
    use GetLangTextTrait;

    const TYPE_NAME = 'gender';

    case Female = 'female';

    case Male = 'male';


}
