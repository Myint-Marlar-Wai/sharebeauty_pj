@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    use App\Http\Routes\SellerRoutes;
    use App\Http\Requests\Seller\Auth\Guest\VerifyEmailVerifyPerformRequest;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\Seller\Auth\VerifyEmailLinkViewResource);
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
            <p class="pwd_setting__txt">
                @foreach(explode(PHP_EOL, __('messages.verify_email.message_verify_confirm.seller')) as $messageLine)
                    {{ $messageLine }}<br>
                @endforeach
            </p>
            <form action="{{ SellerRoutes::urlVerifyEmailVerifyPerform() }}" method="POST"
                  class="form pwd_setting__form" id="setting" novalidate>
                @csrf
                <!-- Verify Email Token -->
                <input
                    type="hidden"
                    name="{{ VerifyEmailVerifyPerformRequest::PARAM_TOKEN }}"
                    value="{{ $vr->hidden_token }}"
                >
                <x-seller::input-field-email
                    id="setting__email"
                    name="{{ VerifyEmailVerifyPerformRequest::PARAM_EMAIL }}"
                    value="{{ $vr->input_email }}"
                    placeholder="ID"
                    autocomplete="username"
                    labelText="ONCE ID（メールアドレス）"
                    readonly
                />

                <button type="submit" id="submit" class="btn btn01 pwd_setting__form__submit">
                    {{ __('messages.verify_email.action_verify_confirm.seller') }}
                </button>
            </form>
        </div>
    </div>
@endsection
