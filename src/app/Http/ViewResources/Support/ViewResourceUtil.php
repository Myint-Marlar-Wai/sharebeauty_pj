<?php

declare(strict_types=1);

namespace App\Http\ViewResources\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\ViewErrorBag;

final class ViewResourceUtil
{
    private function __construct()
    {
    }


    public static function getFirstErrorMessage(ViewErrorBag $errors) : ?string
    {
        return $errors->any() ?
            $errors->first() : null;
    }

    public static function getAllErrorMessageLines(ViewErrorBag $errors) : array
    {
        if (! $errors->any()) {
            return [];
        }

        return Arr::flatten(array_map(function ($value) {
            return explode(PHP_EOL, $value);
        }, Arr::flatten($errors->getMessages(), 1)), 1);
    }

    public static function getAllErrorMessage(ViewErrorBag $errors) : ?string
    {
        if (! $errors->any()) {
            return null;
        }

        return implode(PHP_EOL, Arr::flatten($errors->getMessages(), 1));
    }
}
