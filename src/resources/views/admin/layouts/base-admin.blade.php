@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\ViewResource);
@endphp
@extends('admin.layouts.base-base')
@section(Constants::HEADER)
    <!-- None -->
@endsection
@section(Constants::FOOTER)
    <!-- None -->
@endsection
@section(Constants::SIDEBAR)
    @include('admin.subviews.sidebar-admin')
@endsection
@section(Constants::CONTENT)
    <div class="content_bg">

        <!-- Begin Sidebar -->
        @yield(Constants::SIDEBAR)
        <!-- End Sidebar -->

        <div class="@yield(Constants::MAIN_CONTENT_CONTAINER_CLASS) admin_form_blk">
            @include('admin.subviews.admin-main-content-header')

            <!-- Begin Main content -->
            @yield(Constants::MAIN_CONTENT)
            <!-- End Main content -->
        </div>

    </div>
@endsection
