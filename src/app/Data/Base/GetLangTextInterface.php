<?php

declare(strict_types=1);

namespace App\Data\Base;

interface GetLangTextInterface
{

    const LANG_TEXT_NAME_DEFAULT = 'display_name';

    /**
     * @return string[]
     */
    public static function getLangTextsByValue(string $name = self::LANG_TEXT_NAME_DEFAULT) : array;

    public function getLangText(string $name = self::LANG_TEXT_NAME_DEFAULT): string;

    public function getLangTextTransKey(string $name = self::LANG_TEXT_NAME_DEFAULT): string;
}
