<?php

use App\Data\Bank\BankAccountType;
use App\Data\Common\Gender;
use App\Data\Demo\DemoFormEnum;

return [

    /*
    |--------------------------------------------------------------------------
    | 列挙体の表示用テキスト
    |--------------------------------------------------------------------------
    |
    | デフォルト動作として
    | <enum_type>.display_name.<enum_value> に表示用の名前を定義
    |
    */

    DemoFormEnum::TYPE_NAME => [
        'display_name' => [
            DemoFormEnum::Red->value => '赤',
            DemoFormEnum::Brown->value => '茶',
            DemoFormEnum::Orange->value => '橙',
            DemoFormEnum::Yellow->value => '黄',
            DemoFormEnum::Green->value => '緑',
            DemoFormEnum::Blue->value => '青',
            DemoFormEnum::White->value => '白',
            DemoFormEnum::Black->value => '黒',
        ],
    ],

    BankAccountType::TYPE_NAME => [
        'display_name' => [
            BankAccountType::Savings->value => '普通預金口座',
            BankAccountType::Current->value => '当座預金口座',
        ],
    ],

    Gender::TYPE_NAME => [
        'display_name' => [
            Gender::Female->value => '女性',
            Gender::Male->value => '男性',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | DTO (Value Object) ルール のデフォルトメッセージ
    |--------------------------------------------------------------------------
    |
    |
    */

    'rules' => [
        \App\Rules\Base\BaseRule::TYPE_NAME => [
            'base' => '選択された:attributeは、無効です。',
        ],
        \App\Rules\Base\BaseEnumRule::TYPE_NAME => [
            'base' => '選択された:attributeは、無効です。',
        ],
        \App\Rules\Demo\DemoFormIdRule::TYPE_NAME => [
            'base' => ':attributeは、整数値を入力してください。(デフォルトメッセージ)',
        ],
        \App\Rules\Demo\DemoFormEnumRule::TYPE_NAME => [
            'base' => ':attributeは、規定の値を入力してください。(デフォルトメッセージ)',
        ],
        \App\Rules\BankCodeRule::TYPE_NAME => [
            'base' => ':attributeは、半角数字4桁を入力してください。',
        ],
        \App\Rules\BankAccountTypeRule::TYPE_NAME => [
            'base' => ':attributeは、規定の値を入力してください。',
        ],
        \App\Rules\DisplayOrderIdRule::TYPE_NAME => [
            'base' => ':attributeは、規定の整数値を入力してください。',
        ],
        \App\Rules\PasswordRule::TYPE_NAME => [
            'base' => ':attributeは、大文字小文字含む半角英数字と記号で8文字以上で入力してください。',
            'lowercase_letters' => ':attributeは、小文字英字を含めて入力してください。',
            'uppercase_letters' => ':attributeは、大文字英字を含めて入力してください。',
            'numbers' => ':attributeは、数字を含めて入力してください。',
            'symbols' => ':attributeは、記号を含めて入力してください。',
        ],
        \App\Rules\EmailRule::TYPE_NAME => [
            'base' => ':attributeは、有効なメールアドレスの形式で入力してください。',
        ],
    ],

];
