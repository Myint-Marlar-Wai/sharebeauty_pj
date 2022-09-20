@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    use App\Http\Routes\SellerRoutes;
    use App\Http\Requests\Seller\Auth\Guest\PasswordResetUpdatePerformRequest;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\Seller\Auth\PasswordUpdateViewResource);
    Log::debug('errors', ['errors' => $errors ?? null]);
@endphp
@extends('seller.layouts.base-id')
@prepend(Constants::STACK_SCRIPTS)
    <script src="{{ mix('js/common/password.js') }}"></script>
    <script src="{{ mix('js/id/validation.js') }}"></script>
@endprepend
@section(Constants::CONTENT)
    <div class="pwd_setting content_bg">
        <div class="inner">
            <h1 class="sale_ttl">{{ $vr->getTitle() }}</h1>
            @include('seller.subviews.alert-message')
            <p class="pwd_setting__txt"><span>※</span>パスワードは大文字小文字含む半角英数字と記号（!-_）で8文字以上で設定してください。
            </p>
            <form action="{{ SellerRoutes::urlPasswordResetUpdatePerform() }}" method="POST"
                  class="form pwd_setting__form" id="setting" novalidate>
                @csrf
                <!-- Password Reset Token -->
                <input
                    type="hidden"
                    name="{{ PasswordResetUpdatePerformRequest::PARAM_TOKEN }}"
                    value="{{ $vr->hidden_token }}"
                >
                <x-seller::input-field-email
                    id="setting__email"
                    name="{{ PasswordResetUpdatePerformRequest::PARAM_EMAIL }}"
                    value="{{ $vr->input_email }}"
                    placeholder="ID"
                    autocomplete="username"
                    labelText="ONCE ID（メールアドレス）"
                    readonly
                />
                <x-seller::input-field-password
                    id="new_pwd"
                    name="{{ PasswordResetUpdatePerformRequest::PARAM_NEW_PASSWORD }}"
                    value="{{ $vr->input_new_password }}"
                    autocomplete="new-password"
                    labelText="新しいパスワード"
                    inputWrapperId="pwd"
                />

                <button type="submit" id="submit" class="btn btn01 pwd_setting__form__submit">パスワードを再設定する</button>
            </form>
        </div>
    </div>
@endsection
