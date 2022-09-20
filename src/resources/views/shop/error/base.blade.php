@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
@endphp
@extends('shop.layouts.base')
@section(Constants::CONTENT)
    <div class="error_page user_content content">
        <div class="inner">
            <p class="error_page__txt">@yield('message')<br>
                （{{ "エラーコード： " }}@yield('app_error_code')）</p>
        </div>
    </div>
@endsection
