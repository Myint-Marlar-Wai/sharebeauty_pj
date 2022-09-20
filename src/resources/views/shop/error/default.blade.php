@php
    declare(strict_types=1);
    use App\Http\ViewResources\Error\ErrorViewResource;
    assert(isset($vr) && $vr instanceof ErrorViewResource);
@endphp
@extends('shop.error.base')
@section('status_code', $vr->statusCode)
@section('message')
    @foreach(explode(PHP_EOL, $vr->message) as $line)
        {{ $line }}<br>
    @endforeach
@endsection
@section('app_error_code', $vr->appErrorCode->value)

