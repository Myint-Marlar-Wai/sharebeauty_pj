<?php
declare(strict_types=1);

namespace App\Constants\Views;

final class BladeConstants
{
    private function __construct()
    {
    }

//    /**
//     * @deprecated PageInfoにする
//     */
//    const TITLE = 'title';
//    /**
//     * @deprecated PageInfoにする
//     */
//    const DESCRIPTION = 'description';
//    /**
//     * @deprecated PageInfoにする
//     */
//    const KEYWORDS = 'keywords';

    const HEADER = 'header';

    const FOOTER = 'footer';

    const CONTENT = 'content';

    const SIDEBAR = 'sidebar';

    const MAIN_CONTENT = 'main_content';

    const MAIN_CONTENT_CONTAINER_CLASS = 'main_content_container_class';

    const STACK_META = 'meta';

    const STACK_SCRIPTS = 'scripts';

    const STACK_SCRIPTS_HEAD = 'scripts_head';

    const STACK_STYLESHEETS = 'stylesheets';


}
