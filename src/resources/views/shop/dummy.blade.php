@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
@endphp
@extends('shop.layouts.base')
@section(Constants::CONTENT)
    <div class="dummy_page user_content content">
        <div class="inner">
            <p>Shop Dummy</p>
        </div>
    </div>
@endsection
