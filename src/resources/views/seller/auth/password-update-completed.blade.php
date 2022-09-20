@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    use App\Http\Routes\SellerRoutes;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\Common\DefaultViewResource);
    $vr->setTitle('パスワード設定完了');
@endphp
@extends('seller.layouts.base-id')
@section(Constants::CONTENT)
    <div class="pwd_setting content_bg">
        <h1 class="sale_ttl">{{ $vr->getTitle() }}</h1>
        <div class="inner">
            <p class="pwd_setting__txt pwd">パスワードを再設定しました。<br>新しいパスワードでログインしてください。</p>
            <a href="{{ SellerRoutes::urlLogin() }}" class="btn btn01">ログイン</a>
        </div>
    </div>
@endsection
