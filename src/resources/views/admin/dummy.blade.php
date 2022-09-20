@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
@endphp
@extends('admin.layouts.base-admin')
@section(Constants::MAIN_CONTENT_CONTAINER_CLASS, 'dummy_page')
@section(Constants::MAIN_CONTENT)
    <div class="form_header admin_inner">
        <p class="form_header__txt">Admin Dummy</p>
    </div>
@endsection
