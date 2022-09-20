@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    use App\Http\Routes\ShopRoutes;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\Common\DefaultViewResource);
    $vr->setTitle('パスワード設定完了');
@endphp
@extends('shop.layouts.base')
@section(Constants::CONTENT)
    <div class="no_content">
        <h1 class="shop_ttl">{{ $vr->getTitle() }}</h1>
        <div class="inner">
            <p class="pwd_setting__txt pwd">パスワードを再設定しました。<br>新しいパスワードでログインしてください。</p>
            <a href="{{ ShopRoutes::urlLogin() }}" class="btn btn01">ログイン</a>
        </div>
    </div>
@endsection
