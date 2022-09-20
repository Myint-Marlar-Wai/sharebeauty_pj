<?php

declare(strict_types=1);

namespace App\Data\Base;

use BackedEnum;
use UnitEnum;

trait GetLangTextTrait
{


    /**
     * @return string[]
     */
    public static function getLangTextsByValue(string $name = GetLangTextInterface::LANG_TEXT_NAME_DEFAULT): array
    {
        $map = [];
        /** @var BackedEnum&GetLangTextInterface $i */
        foreach (static::cases() as $i) {
            $map[$i->value] = $i->getLangText($name);
        }

        return $map;
    }

    public function getLangText(string $name = GetLangTextInterface::LANG_TEXT_NAME_DEFAULT): string
    {
        /** @var UnitEnum&GetLangTextInterface $this */
        return trans($this->getLangTextTransKey($name));
    }

    public function getLangTextTransKey(string $name = GetLangTextInterface::LANG_TEXT_NAME_DEFAULT): string
    {
        /** @var UnitEnum&GetLangTextInterface $this */
        return 'data.'.static::TYPE_NAME.'.'.$name.'.'.$this->value;
    }
}
