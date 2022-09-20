@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    use App\Http\Routes\ShopRoutes;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\Common\DefaultViewResource);
    $vr->setTitle('パスワード変更完了');
@endphp
@extends('shop.layouts.base')
@section(Constants::CONTENT)
    <div class="no_content">
        <div class="inner">
            <h1 class="shop_ttl pwd_accept_completed__ttl">{{ $vr->getTitle() }}</h1>
            <p class="pwd_accept_completed__txt">パスワードの変更が完了しました。<br>
                一度ログアウトしますと、今回設定いただいたパスワードでログインできるようになります。</p>
            <a href="{{ ShopRoutes::urlMember() }}" class="btn btn01">会員情報に戻る</a>
        </div>
    </div>
@endsection
