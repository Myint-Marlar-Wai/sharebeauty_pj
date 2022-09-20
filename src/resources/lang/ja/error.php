<?php

declare(strict_types=1);

use App\Exceptions\AppErrorCode as AE;

return [

    /**
     * エラー用テキスト
     *
     * @see \App\Exceptions\AppErrorCode
     */
    AE::BadRequest->value => [
        'message' => '無効なリクエストです。リンクや入力内容が正しいかをご確認の上、最新の状態で再度実行してください。',
    ],
    AE::BadRequestJson->value => [
        'message' => 'JSON形式が不正です。',
    ],
    AE::BadRequestRouteParameter->value => [
        'message' => '指定された値は有効ではありません。',
        'message-a' => ':attributeは有効な値ではありません。',
    ],
    AE::BadRequestParameter->value => [
        'message' => '指定された値は有効ではありません。',
        'message-a' => ':attributeは有効な値ではありません。',
    ],
    AE::Unauthenticated->value => [
        'message' => '認証されていません。',
    ],
    AE::AccessDenied->value => [
        'message' => 'アクセスが拒否されました。'.PHP_EOL
            .'最新の状態で再度実行してください。',
    ],
    AE::InvalidSignature->value => [
        'message' => 'リンクの署名が無効です。有効期限が切れている、もしくは内容が正しくありません。'.PHP_EOL
            .'最新の状態で再度実行してください。',
    ],
    AE::NotFoundPage->value => [
        'message' => 'ページがみつかりませんでした。URLをご確認ください。',
    ],
    AE::NotFoundEndpoint->value => [
        'message' => '存在しないエンドポイントです。URLをご確認ください。',
    ],
    AE::NotFoundResource->value => [
        'message' => ' リソースが見つかりませんでした。削除された、もしくは閲覧権限がありません。',
        'message-a' => ':attributeが見つかりませんでした。削除された、もしくは閲覧権限がありません。',
    ],
    AE::ExpiredPageByCSRF->value => [
        'message' => 'ページの有効期限が切れています。再読み込みをお試しください。',
    ],
    AE::ValidationError->value => [
        'message' => '指定された値は有効ではありません。',
    ],
    AE::InvalidParameter->value => [
        'message' => '指定された値は有効ではありません。',
        'message-a' => ':attributeは有効な値ではありません。',
    ],
    AE::TooManyAttempts->value => [
        'message' => '試行回数が多すぎます。しばらく待機してからお試しください。',
    ],
    AE::DemoNeedsInputProfile->value => [
        'message' => 'プロフィールの入力を完了してください。(デモ)',
    ],
    AE::UserAlreadyExists->value => [
        'message' => '既にユーザーが存在します。',
    ],
    AE::NoPasswordOnPasswordChange->value => [
        'message' => 'パスワードを使用したログインではないため、パスワード変更を利用できません。',
    ],
    AE::MismatchCurrentPassword->value => [
        'message' => '現在のパスワードが一致しません。',
    ],
    AE::Unknown->value => [
        'message' => 'サーバーで予期せぬエラーが発生しました。'.PHP_EOL
            .'しばらく待って再度実行してください。'.PHP_EOL
            .'現象が改善されない場合はサポートにお問い合わせください。',
    ],

    'app_error_default' => [
        'message' => 'アプリケーションエラーが発生しました。'.PHP_EOL
            .'しばらく待って再度実行してください。'.PHP_EOL
            .'現象が改善されない場合はサポートにお問い合わせください。',
    ],
];
