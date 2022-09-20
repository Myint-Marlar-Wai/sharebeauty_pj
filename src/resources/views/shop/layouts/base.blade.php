@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\ViewResource);
@endphp
@prepend(Constants::STACK_STYLESHEETS)
    <link rel="stylesheet" href="{{ mix('fonts/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/shop/style.css') }}">
@endprepend
@prepend(Constants::STACK_SCRIPTS)
    <script src="{{ mix('js/common/lib/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ mix('js/shop/common.js') }}"></script>
@endprepend
@section(Constants::HEADER)
    @include('shop.subviews.header')
@endsection
@section(Constants::FOOTER)
    @include('shop.subviews.footer')
@endsection
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
    @stack(Constants::STACK_META)

    <title>{{ $vr->getPageInfo()->getOutputTitle() }}</title>
    <meta name="description" itemprop="description" content="{{$vr->getPageInfo()->getOutputDescription()}}">
    <meta name="keywords" itemprop="keywords" content="{{$vr->getPageInfo()->getOutputKeywords()}}">

    <!-- Begin scripts -->
    @stack(Constants::STACK_SCRIPTS_HEAD)
    <!-- End scripts -->

    <!-- Begin stylesheets -->
    @stack(Constants::STACK_STYLESHEETS)
    <!-- End stylesheets -->
</head>

<body>
<div class="wrapper">
    <!-- Begin header -->
    @yield(Constants::HEADER)
    <!-- End header -->

    <!-- Begin content -->
    @yield(Constants::CONTENT)
    <!-- End content -->

    <!-- Begin footer -->
    @yield(Constants::FOOTER)
    <!-- End footer -->
</div>
<!-- Begin scripts -->
@stack(Constants::STACK_SCRIPTS)
<!-- End scripts -->
</body>

</html>

