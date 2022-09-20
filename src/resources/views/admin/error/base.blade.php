@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
@endphp
@extends('admin.layouts.base-simple')
@section(Constants::CONTENT)
    <div class="admin_error">
        <div class="inner">
            <p class="admin_error__msg">@yield('message')<br>
                （{{ "エラーコード： " }}@yield('app_error_code')</p>
        </div>
    </div>
@endsection
