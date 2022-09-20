@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    use App\Http\Routes\ShopRoutes;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\Shop\Auth\VerifyEmailIndexViewResource);
@endphp
@extends('shop.layouts.base')
@section(Constants::CONTENT)
    <div class="contact_form_complete user_content">
        <div class="inner">
            <h1 class="shop_ttl">{{ $vr->getTitle() }}</h1>
            <p class="contact_form_complete__txt">
                {{--                @foreach(explode(PHP_EOL, $vr->getSentMessage()) as $line){{ $line }}<br>@endforeach--}}
                {{ $vr->getSentMessage() }}
                @if($vr->atVerificationLinkSent !== null)
                    <br>{{ $vr->getSentDateTimeMessage() }}
                @endif
            </p>
            @include('shop.subviews.alert-message')

            <form method="POST" action="{{ ShopRoutes::urlVerifyEmailSend() }}">
                @csrf
                @if($vr->isVerificationLinkResent)
                    {{-- TODO disabled button --}}
                    <button type="submit" class="" disabled>
                        {{ __('messages.verify_email.action_resend') }}
                    </button>
                @else
                    <button type="submit" class="btn btn01">
                        {{ __('messages.verify_email.action_resend') }}
                    </button>
                @endif
            </form>

            <form method="POST" action="{{ ShopRoutes::urlLogoutPerform() }}">
                @csrf
                <button type="submit" class="btn btn01">
                    {{ __('messages.logout') }}
                </button>
            </form>
        </div>
    </div>

@endsection
