<?php

declare(strict_types=1);

return [

    'hello' => 'こんにちは',
    'logout' => 'ログアウト',

    'verify_email' => [
        'message_sent' => [
            'seller' => 'ご登録いただいたメールアドレス(:email)にメールを送信しています。'.PHP_EOL
                .'記載の認証URLへアクセスし ONCE ID の登録を完了してください。',
            'shop' => 'ご登録いただいたメールアドレス(:email)にメールを送信しています。'.PHP_EOL
                .'記載の認証URLへアクセスし 会員登録を完了してください。',
        ],
        'message_verify_confirm' => [
            'seller' => '以下のメールアドレスで登録を完了します。'.PHP_EOL
                .'メールアドレスに間違いがなければ、「登録」を押してください。',
            'shop' => '以下のメールアドレスで登録を完了します。'.PHP_EOL
                .'メールアドレスに間違いがなければ、「登録」を押してください。',
        ],
        'message_resent_new_link' => '新しい確認用リンクが送信されました。',
        'action_resend' => '認証メールを再送する',
        'action_verify_confirm' => [
            'seller' => '登録',
            'shop' => '登録',
        ],
    ],

    'password_change_completed' => 'パスワードを変更しました。',
];
