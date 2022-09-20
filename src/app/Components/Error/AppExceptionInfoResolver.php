<?php

declare(strict_types=1);

namespace App\Components\Error;

use App\Exceptions\AppErrorCode;
use App\Exceptions\Support\AppErrorResolvedInfo;
use Illuminate\Support\Arr;

class AppExceptionInfoResolver
{
    public function resolve(AppErrorCode $appCode, array $args): AppErrorResolvedInfo
    {

        // 通常のメッセージ
        $transKey = 'error.'.$appCode->value.'.message';
        // 置換ありのメッセージ
        $transKeyArg = 'error.'.$appCode->value.'.message-a';

        $args = $args ? Arr::whereNotNull($args) : $args;

        if ($args) {
            if (isset($args['attribute'])) {
                // 属性の翻訳
                $transKeyAttr = 'validation.attributes.'.$args['attribute'];
                $tAttr = trans($transKeyAttr);
                if ($tAttr !== $transKeyAttr && $tAttr !== '') {
                    $args['attribute'] = $tAttr;
                }
            }
            // 置換文字付き
            $tMessage = trans($transKeyArg, $args);
            if ($tMessage === $transKeyArg) {
                // 置換文字付きメッセージがない場合のフォールバック
                $tMessage = trans($transKey);
            }
        } else {
            $tMessage = trans($transKey);
        }

        $message = '';
        if ($tMessage !== $transKey && $tMessage !== '') {
            $message = $tMessage;
        }
        $status = $appCode->getStatusCodeInt();
        $resourceStatus = $appCode->getResourceCodeInt();

        $resolved = new AppErrorResolvedInfo();
        $resolved->message = $message;
        $resolved->status = $status;
        $resolved->resourceStatus = $resourceStatus;
        return $resolved;
    }
}
