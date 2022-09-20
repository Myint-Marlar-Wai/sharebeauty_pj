@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    use App\Http\Routes\SellerRoutes;
    use App\Http\Requests\Seller\Auth\Guest\PasswordResetSendLinkRequest;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\Seller\Auth\PasswordResetViewResource);
@endphp
@extends('seller.layouts.base-id')
@prepend(Constants::STACK_SCRIPTS)
    <script src="{{ mix('js/common/password.js') }}"></script>
    <script src="{{ mix('js/id/validation.js') }}"></script>
@endprepend
@section(Constants::CONTENT)
    <div class="pwd_change content_bg">
        <div class="inner">
            <h1 class="sale_ttl">{{ $vr->getTitle() }}</h1>
            @include('seller.subviews.alert-message')
            <p class="pwd_reset__txt">TODO: ダミーメッセージです。<br>ダミーメッセージです、ダミーメッセージです。</p>
            <form action="{{ SellerRoutes::urlPasswordResetSendLink() }}" method="POST"
                  class="form pwd_reset__form" id="password-reset" novalidate>
                @csrf
                <x-seller::input-field-email
                    id="reset__email"
                    name="{{ PasswordResetSendLinkRequest::PARAM_EMAIL }}"
                    value="{{ $vr->input_email }}"
                    placeholder="ID（メールアドレス）"
                    autocomplete="username"
                    labelText="ONCE ID"
                />
                <button type="submit" id="submit" class="btn btn01 pwd_reset__form__submit">パスワードを変更する</button>
            </form>
        </div>
    </div>
@endsection
