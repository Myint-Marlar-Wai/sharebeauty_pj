@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\ViewResource);
@endphp
@extends('admin.layouts.base-base')
@section(Constants::HEADER)
    @include('admin.subviews.header-simple')
@endsection
@section(Constants::FOOTER)
    @include('admin.subviews.footer-simple')
@endsection
