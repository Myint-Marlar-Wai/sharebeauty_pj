@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    use App\Http\Requests\Seller\Auth\Guest\LoginPerformRequest;
    use App\Http\Routes\SellerRoutes;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\Seller\Auth\LoginViewResource);
    Log::debug('errors', ['errors' => $errors ?? null]);
@endphp
@extends('seller.layouts.base-id')
@prepend(Constants::STACK_META)
    {{--    <meta name="google-signin-client_id" content="{{ config('services.google.client_id') }}">--}}
    {{--    <meta name="google-signin-scope" content="profile email">--}}
@endprepend
@prepend(Constants::STACK_SCRIPTS_HEAD)
    <script src="https://accounts.google.com/gsi/client"></script>
    {{--    <script src="https://apis.google.com/js/api:client.js"></script>--}}
@endprepend
@prepend(Constants::STACK_SCRIPTS)
    <script src="{{ mix('js/common/password.js') }}"></script>
    <script src="{{ mix('js/id/validation.js') }}"></script>
    {{--    <script>startApp();</script>--}}
@endprepend
@section(Constants::CONTENT)
    <div class="login content_bg">
        <h1 class="sale_ttl">{{ $vr->getTitle() }}</h1>
        @include('seller.subviews.alert-message')
        <div class="inner">
            <form action="{{ SellerRoutes::urlLoginPerform() }}" method="post"
                  novalidate class="form login__form"
                  id="login">
                @csrf
                <x-seller::input-field-email
                    id="email"
                    name="{{ LoginPerformRequest::PARAM_EMAIL }}"
                    value="{{ $vr->input_email }}"
                    placeholder="ID"
                    autocomplete="username"
                    labelText="ONCE ID（メールアドレス）"
                />
                <x-seller::input-field-password
                    id="password"
                    name="{{ LoginPerformRequest::PARAM_PASSWORD }}"
                    value="{{ $vr->input_password }}"
                    autocomplete="current-password"
                    labelText="パスワード"
                    inputWrapperId="pwd"
                />
                <button type="submit" id="submit" class="btn btn01 login__form__submit">ONCE ID でログインする</button>
            </form>
            <div class="forgot_password login__forgot_password">
                <a href="{{ SellerRoutes::urlPasswordReset() }}">{{ '>> '.'パスワードを忘れた方' }}</a>
            </div>
            <h2 class="title login__ttl ">{{ 'Google アカウント ログイン' }}</h2>
            <div class="login__btn" id="google_btn">
                <a href="{{ SellerRoutes::urlAuthGoogleForLogin() }}" class="btn g_btn"><span><img
                            src="{{ mix('images/ico_google.png') }}" alt="google"></span>Googleアカウントでログイン</a>
            </div>
        </div>
    </div>
@endsection
