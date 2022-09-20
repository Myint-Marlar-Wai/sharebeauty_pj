@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;use App\Http\Requests\Seller\Auth\VerifyEmailSendPerformRequest;use App\Http\Routes\SellerRoutes;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\Seller\Auth\VerifyEmailIndexViewResource);
@endphp
@extends('seller.layouts.base-id')
@section(Constants::CONTENT)
    <div class="registration_completed content_bg">
        <h1 class="sale_ttl">{{ $vr->getTitle() }}</h1>
        <div class="inner">
            <p class="registration_completed__txt">
                {{ $vr->getSentMessage() }}
                @if($vr->atVerificationLinkSent !== null)
                    <br>{{ $vr->getSentDateTimeMessage() }}
                @endif
            </p>
            @include('seller.subviews.alert-message')
            @if($vr->canResendVerificationLink)
                <form method="POST" action="{{ SellerRoutes::urlVerifyEmailSendPerform() }}">
                    @csrf
                    <input type="hidden" name="{{ VerifyEmailSendPerformRequest::PARAM_EMAIL }}"
                           value="{{ $vr->hidden_email }}">
                    @if($vr->isVerificationLinkResent)
                        {{-- TODO disabled button --}}
                        <button type="submit" class="" disabled>
                            {{ __('messages.verify_email.action_resend') }}
                        </button>
                    @else
                        <button type="submit" class="btn btn01 registration__form__submit">
                            {{ __('messages.verify_email.action_resend') }}
                        </button>
                    @endif
                </form>
            @endif
            @if($vr->isLoggedIn)
                <form method="POST" action="{{ SellerRoutes::urlLogoutPerform() }}">
                    @csrf
                    <button type="submit" class="btn btn01 registration__form__submit">
                        {{ __('messages.logout') }}
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection
