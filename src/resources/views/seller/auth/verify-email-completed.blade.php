@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    use App\Http\Routes\SellerRoutes;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\Common\DefaultViewResource);
    $vr->setTitle('メールアドレスの確認完了');
@endphp
@extends('seller.layouts.base-id')
@section(Constants::CONTENT)
    <div class="pwd_setting content_bg">
        <h1 class="sale_ttl">{{ $vr->getTitle() }}</h1>
        <div class="inner">
            <p class="pwd_setting__txt pwd">メールアドレスの確認が完了しました。</p>
            <a href="{{ SellerRoutes::urlHome() }}" class="btn btn01">トップへ</a>
        </div>
    </div>
@endsection
