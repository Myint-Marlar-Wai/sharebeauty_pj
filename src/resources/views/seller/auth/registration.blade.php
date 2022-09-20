@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    use App\Http\Requests\Seller\Auth\Guest\RegistrationPerformRequest;
    use App\Http\Routes\SellerRoutes;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\Seller\Auth\RegistrationViewResource);
@endphp
@extends('seller.layouts.base-id')
@prepend(Constants::STACK_SCRIPTS_HEAD)
    <script src="https://accounts.google.com/gsi/client"></script>
@endprepend
@prepend(Constants::STACK_SCRIPTS)
    <script src="{{ mix('js/common/password.js') }}"></script>
    <script src="{{ mix('js/id/validation.js') }}"></script>
@endprepend
@section(Constants::CONTENT)
    <div class="registration content_bg">
        <h1 class="sale_ttl">{{ $vr->getTitle() }}</h1>
        @include('seller.subviews.alert-message')
        <div class="inner">
            <div class="registration__txt">
                <p><span>※</span>登録の完了に必要なURLを登録ONCE ID（メールアドレス）に送付します。</p>
                <p><span>※</span>パスワードは大文字小文字含む半角英数字と記号（!-_）で8文字以上で設定してください。</p>
            </div>
            <form action="{{ SellerRoutes::urlRegistrationPerform() }}" method="post"
                  novalidate class="form registration__form" id="registration">
                @csrf
                <x-seller::input-field-email
                    id="email"
                    name="{{ RegistrationPerformRequest::PARAM_EMAIL }}"
                    value="{{ $vr->input_email }}"
                    placeholder="ID"
                    autocomplete="username"
                    labelText="ONCE ID（メールアドレス）"
                />
                <x-seller::input-field-password
                    id="password"
                    name="{{ RegistrationPerformRequest::PARAM_PASSWORD }}"
                    value="{{ $vr->input_password }}"
                    autocomplete="new-password"
                    labelText="パスワード"
                    inputWrapperId="pwd"
                />
                <button type="submit" id="submit" class="btn btn01 registration__form__submit">ONCE ID を登録する</button>
            </form>
            <div class="forgot_password login__forgot_password">
                <a href="{{ SellerRoutes::urlPasswordReset() }}">&gt;&gt; パスワードを忘れた方</a>
            </div>
            <h2 class="title login__ttl ">{{ 'Googleアカウントで登録' }}</h2>
            <div class="login__btn" id="google_btn">
                <a href="{{ SellerRoutes::urlAuthGoogleForRegistration() }}" class="btn g_btn"><span><img
                            src="{{ mix('images/ico_google.png') }}" alt="google"></span>Googleアカウントでログイン</a>
            </div>
        </div>
    </div>
@endsection
