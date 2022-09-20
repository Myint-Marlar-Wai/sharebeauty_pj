@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
@endphp
@extends('seller.layouts.base-base')
@section(Constants::HEADER)
    @include('seller.subviews.header-id')
@endsection
@section(Constants::FOOTER)
    @include('seller.subviews.footer-id')
@endsection
@prepend(Constants::STACK_STYLESHEETS)
    <link rel="stylesheet" href="{{ mix('css/id/style.css') }}">
@endprepend
@prepend(Constants::STACK_SCRIPTS)
    <script src="{{ mix('js/id/common.js') }}"></script>
@endprepend

