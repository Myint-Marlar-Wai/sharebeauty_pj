<?php

declare(strict_types=1);

namespace App\Data\Demo;

use App\Data\Base\GetLangTextInterface;
use App\Data\Base\GetLangTextTrait;

enum DemoFormEnum: string implements GetLangTextInterface
{
    use GetLangTextTrait;

    const TYPE_NAME = 'demo_form_enum';

    /**
     * 赤
     */
    case Red = 'red';

    /**
     * 茶色
     */
    case Brown = 'brown';

    /**
     * オレンジ
     */
    case Orange = 'orange';

    /**
     * 黄色
     */
    case Yellow = 'yellow';

    /**
     * 緑
     */
    case Green = 'green';

    /**
     * 青
     */
    case Blue = 'blue';


    /**
     * 白
     */
    case White = 'white';

    /**
     * 黒
     */
    case Black = 'black';
}
