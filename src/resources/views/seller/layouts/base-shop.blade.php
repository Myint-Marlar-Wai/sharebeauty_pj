@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
@endphp
@extends('seller.layouts.base-base')
@section(Constants::HEADER)
    @include('seller.subviews.header-shop')
@endsection
@section(Constants::FOOTER)
    @include('seller.subviews.footer-shop')
@endsection
@prepend(Constants::STACK_STYLESHEETS)
    <link rel="stylesheet" href="{{ mix('css/ec/style.css') }}">
@endprepend
@prepend(Constants::STACK_SCRIPTS)
    <script src="{{ mix('js/ec/common.js') }}"></script>
    <script src="{{ mix('js/ec/validation.js') }}"></script>
@endprepend

