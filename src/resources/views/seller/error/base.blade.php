@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
@endphp
@extends('seller.layouts.base-id')
@section(Constants::CONTENT)
    <div class="error_page">
        <div class="inner">
            <p class="error_page__txt">@yield('message')<br>
                （{{ "エラーコード： " }}@yield('app_error_code')）</p>
        </div>
    </div>
@endsection
