@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    use App\Http\Requests\Shop\Auth\Guest\LoginPerformRequest;
    use App\Http\Routes\ShopRoutes;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\Shop\Auth\LoginViewResource);
    Log::debug('errors', ['errors' => $errors ?? null]);
@endphp
@extends('shop.layouts.base')
@prepend(Constants::STACK_SCRIPTS)
    <script src="{{ mix('js/common/password.js') }}"></script>
    <script src="{{ mix('js/shop/validation.js') }}"></script>
@endprepend
@section(Constants::CONTENT)
    <div class="shoplogin user_content content_bg">
        <h1 class="shop_ttl">{{ $vr->getTitle() }}</h1>
        @include('shop.subviews.alert-message')
        <div class="inner">
{{--            <div class="alert_message shoplogin__alert_message hide">ログインできませんでした。<br>IDまたはパスワードが間違っています。</div>--}}
            <form action="{{ ShopRoutes::urlLoginPerform() }}" method="post"
                  class="form shoplogin__form" id="login" novalidate>
                @csrf
                <x-shop::input-field-email
                    id="email"
                    name="{{ LoginPerformRequest::PARAM_EMAIL }}"
                    value="{{ $vr->input_email }}"
                    autocomplete="username"
                    labelText="メールアドレス"
                />
                <x-shop::input-field-password
                    id="password"
                    name="{{ LoginPerformRequest::PARAM_PASSWORD }}"
                    value="{{ $vr->input_password }}"
                    class="validate"
                    autocomplete="current-password"
                    labelText="パスワード"
                    inputWrapperId="pwd"
                />
                <div class="login__forgot_password">
                    <a href="{{ ShopRoutes::urlPasswordReset() }}">{{ '>> '.'パスワードを忘れた方' }}</a>
                </div>
                <button type="submit" id="submit" class="btn btn01 shoplogin__form__submit">ログインする</button>
            </form>
        </div>
    </div>
@endsection
