<?php

declare(strict_types=1);

namespace App\Http\Routes;

use App\Data\Demo\DemoFormId;

final class DemoRoutes
{
    private function __construct()
    {
    }

    const WEB_FORM = 'demo.web.form';

    const WEB_FORM_UPDATE = 'demo.web.form.update';

    const WEB_FORM_CLEAR = 'demo.web.form.clear';

    const API_FORM = 'demo.api.form';

    const API_FORM_UPDATE = 'demo.api.form.update';

    const API_FORM_CLEAR = 'demo.api.form.clear';

    /*
    |--------------------------------------------------------------------------
    | Param
    |--------------------------------------------------------------------------
    |
    |
    */
    const PARAM_FORM_ID = 'demo_form_id';

    /*
    |--------------------------------------------------------------------------
    | Demo Web Form
    |--------------------------------------------------------------------------
    |
    |
    */

    public static function urlDemoWebForm(DemoFormId $id) : string
    {
        return route(self::WEB_FORM, [self::PARAM_FORM_ID => $id->getIntString()]);
    }

    public static function urlDemoWebFormUpdate(DemoFormId $id) : string
    {
        return route(self::WEB_FORM_UPDATE, [self::PARAM_FORM_ID => $id->getIntString()]);
    }

    public static function urlDemoWebFormClear(DemoFormId $id) : string
    {
        return route(self::WEB_FORM_CLEAR, [self::PARAM_FORM_ID => $id->getIntString()]);
    }


    /*
    |--------------------------------------------------------------------------
    | Demo API Form
    |--------------------------------------------------------------------------
    |
    |
    */

    public static function urlDemoApiForm(DemoFormId $id) : string
    {
        return route(self::API_FORM, [self::PARAM_FORM_ID => $id->getIntString()]);
    }

    public static function urlDemoApiFormUpdate(DemoFormId $id) : string
    {
        return route(self::API_FORM_UPDATE, [self::PARAM_FORM_ID => $id->getIntString()]);
    }

    public static function urlDemoApiFormClear(DemoFormId $id) : string
    {
        return route(self::API_FORM_CLEAR, [self::PARAM_FORM_ID => $id->getIntString()]);
    }
}
