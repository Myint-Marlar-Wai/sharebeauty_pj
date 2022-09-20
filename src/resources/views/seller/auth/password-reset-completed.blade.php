@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    use App\Http\Routes\SellerRoutes;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\Common\DefaultViewResource);
    $vr->setTitle('送信完了');
@endphp
@extends('seller.layouts.base-id')
@section(Constants::CONTENT)
    <div class="pwd_reset content_bg">
        <h1 class="sale_ttl">{{ $vr->getTitle() }}</h1>
        <div class="inner">
            <p class="pwd_reset__txt">
                ご登録いただいたメールアドレス（ONCE ID）にパスワード再設定用のメールを送信しました。
                記載のURLへアクセスしパスワードを再設定してください。
                メールが届かない場合はメールアドレスを確認いただくか、別のメールアドレスをお試しください。
            </p>
            <a href="{{ SellerRoutes::urlHome() }}" class="btn btn01">ONCE ECトップへ</a>
        </div>
    </div>
@endsection
