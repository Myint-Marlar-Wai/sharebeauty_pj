<?php

declare(strict_types=1);

return [

    \App\Http\Requests\Demo\DemoFormUpdateRequest::LANG_NAME => [
        'display_order_id' => [
            'base' => ':attributeは、規定の整数値を入力してください。(オーバーライドサンプル)',
            'required' => ':attributeは、必須項目です。(オーバーライドサンプル)',
        ],
    ],

    \App\Http\Requests\Seller\Auth\Guest\LoginPerformRequest::LANG_NAME => [
        'auth' => [
            'failed' => "ログインできませんでした。\nIDまたはパスワードが間違っています。",
        ],
    ],
    \App\Http\Requests\Shop\Auth\Guest\LoginPerformRequest::LANG_NAME => [
        'auth' => [
            'failed' => "ログインできませんでした。\nIDまたはパスワードが間違っています。",
        ],
    ],

];
