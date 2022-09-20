@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    use App\Http\Routes\ShopRoutes;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\Common\DefaultViewResource);
    $vr->setTitle('送信完了');
@endphp
@extends('shop.layouts.base')
@section(Constants::CONTENT)
    <div class="no_content">
        <h1 class="shop_ttl">{{ $vr->getTitle() }}</h1>
        <div class="inner">
            <p class="pwd_reset__txt">
                ご登録いただいたメールアドレスにパスワード再設定用のメールを送信しました。
                記載のURLへアクセスしパスワードを再設定してください。
                メールが届かない場合はメールアドレスを確認いただくか、別のメールアドレスをお試しください。
            </p>
            <a href="{{ ShopRoutes::urlHome() }}" class="btn btn01">トップへ</a>
        </div>
    </div>
@endsection
