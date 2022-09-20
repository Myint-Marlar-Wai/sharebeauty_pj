@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    use App\Http\Routes\ShopRoutes;
    use App\Http\Requests\Shop\Auth\PasswordChangePerformRequest;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\Shop\Auth\PasswordChangeViewResource);
    Log::debug('errors', ['errors' => $errors ?? null]);
@endphp
@extends('shop.layouts.base')
@prepend(Constants::STACK_SCRIPTS)
    <script src="{{ mix('js/common/password.js') }}"></script>
    <script src="{{ mix('js/shop/validation.js') }}"></script>
@endprepend
@section(Constants::CONTENT)
    <div class="shoplogin user_content content_bg">
        <div class="inner">
            <h1 class="shop_ttl">{{ $vr->getTitle() }}</h1>
            @include('shop.subviews.alert-message')
            <p class="pwd_change__txt"><span>※</span>パスワードは大文字小文字含む半角英数字と記号（!-_）で8文字以上で設定してください。</p>
            <form action="{{ ShopRoutes::urlPasswordChangePerform() }}" method="POST"
                  class="form" id="password-change" novalidate>
                @csrf
                <x-shop::input-field-password
                    id="current-password"
                    name="{{ PasswordChangePerformRequest::PARAM_CURRENT_PASSWORD }}"
                    value="{{ $vr->input_current_password }}"
                    autocomplete="current-password"
                    labelText="現在のパスワード"
                    inputWrapperId="current_pwd"
                />
                <x-shop::input-field-password
                    id="new-password"
                    name="{{ PasswordChangePerformRequest::PARAM_NEW_PASSWORD }}"
                    value="{{ $vr->input_new_password }}"
                    autocomplete="new-password"
                    labelText="新しいパスワード"
                    inputWrapperId="new_pwd"
                />
                <button type="submit" id="submit" class="btn btn01">パスワードを変更する</button>
            </form>
        </div>
    </div>
@endsection
