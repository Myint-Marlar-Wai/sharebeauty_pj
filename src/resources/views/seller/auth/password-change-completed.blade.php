@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    use App\Http\Routes\SellerRoutes;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\Common\DefaultViewResource);
    $vr->setTitle('パスワード変更完了');
@endphp
@extends('seller.layouts.base-id')
@section(Constants::CONTENT)
    <div class="pwd_accept_completed content_bg">
        <div class="inner">
            <h1 class="sale_ttl pwd_accept_completed__ttl">{{ $vr->getTitle() }}</h1>
            <p class="pwd_accept_completed__txt">パスワードの変更が完了しました。<br>
                一度ログアウトしますと、今回設定いただいたパスワードでログインできるようになります。</p>
            <a href="{{ SellerRoutes::urlSetting() }}" class="btn btn01">アカウント設定に戻る</a>
        </div>
    </div>
@endsection
