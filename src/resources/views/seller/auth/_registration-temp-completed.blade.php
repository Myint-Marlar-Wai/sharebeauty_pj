@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\Common\DefaultViewResource);
    $vr->setTitle('仮登録完了');
@endphp
@extends('seller.layouts.base-id')
@section(Constants::CONTENT)
    <div class="registration_completed content_bg">
        <h1 class="sale_ttl">{{ $vr->getTitle() }}</h1>
        <div class="inner">
            <p class="registration_completed__txt">ご登録いただいたONCE ID（メールアドレス）にメールを送信しました。
                記載の認証URLへアクセスし ONCE ID の登録を完了してください。</p>
        </div>
    </div>
@endsection
