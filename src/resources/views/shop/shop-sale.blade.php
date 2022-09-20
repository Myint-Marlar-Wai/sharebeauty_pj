<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ショップ別売上(オーナーショップ)</title>
    <link rel="stylesheet" href="{{ mix('fonts/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/common/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/shop/style.css') }}">
</head>

<body>
    <div class="wrapper">
        <!-- Begin MODULE Shop Header -->
        @include('components.shop-header')
        <!-- End MODULE Shop Header -->
        <div class="shop_content shop_sale content">
            <div class="inner">
                <h2 class="shop_ttl">売上管理</h2>
                <ul class="calendar_type">
                    <li><a href="#day">日別</a></li>
                    <li><a href="#month">月別</a></li>
                </ul>
                <ul class="calendar_data">
                    <li id="day" class="calendar_data__content">
                        <div class="picker">
                            <input type="text" class="shop_sale__datetime_picker datepicker" />
                            <button class="picker__prev prev_day"><i class="fa-solid fa-angle-left"></i></button>
                            <button class="picker__next next_day"><i class="fa-solid fa-angle-right"></i></button>
                        </div>
                        <ul class="shop_sale__data_list">
                            <li class="shop_sale__data_list__data">
                                <p class="shop_sale__data_list__name">売上</p>
                                <p id="once_amount" class="shop_sale__data_list__value">¥0</p>
                                <p id="once_dayBeforeRatio" class="shop_sale__data_list__difference"><span>前日差</span><span class="yen">¥0</span></p>
                            </li>
                            <li class="shop_sale__data_list__data">
                                <p class="shop_sale__data_list__name">報酬額</p>
                                <p id="once_sellers_reward" class="shop_sale__data_list__value">¥0</p>
                            </li>
                            <li class="shop_sale__data_list__data">
                                <p class="shop_sale__data_list__name">販売個数</p>
                                <p id="once_quantity" class="shop_sale__data_list__value">0</p>
                            </li>
                            @if($shops)
                            <li class="store_list">
                                <p class="shop_sale__data_list__name">店舗別売上</p>
                                <ul class="shop_sale__data_list__stores">
                                    @foreach ($shops as $shop)
                                    <li><a href="/shop/sale/{{ $shop->id }}">{{ $shop->shop_name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </li>
                    <li id="month" class="calendar_data__content">
                        <div class="picker">
                            <input type="text" class="shop_sale__datetime_picker monthpicker" />
                            <button class="picker__prev prev_month"><i class="fa-solid fa-angle-left"></i></button>
                            <button class="picker__next next_month"><i class="fa-solid fa-angle-right"></i></button>
                        </div>
                        <ul class="shop_sale__data_list">
                            <li class="shop_sale__data_list__data">
                                <p class="shop_sale__data_list__name">売上</p>
                                <p id="once_amount" class="shop_sale__data_list__value">¥0</p>
                                <p id="once_dayBeforeRatio" class="shop_sale__data_list__difference"><span>前月差</span><span class="yen">¥0</span></p>
                            </li>
                            <li class="shop_sale__data_list__data">
                                <p class="shop_sale__data_list__name">報酬額</p>
                                <p id="once_sellers_reward" class="shop_sale__data_list__value">¥0</p>
                            </li>
                            <li class="shop_sale__data_list__data">
                                <p class="shop_sale__data_list__name">販売個数</p>
                                <p id="once_quantity" class="shop_sale__data_list__value">0</p>
                            </li>
                            @if($shops)
                            <li class="store_list">
                                <p class="shop_sale__data_list__name">店舗別売上</p>
                                <ul class="shop_sale__data_list__stores">
                                    @foreach ($shops as $shop)
                                    <li><a href="/shop/sale/{{ $shop->id }}">{{ $shop->shop_name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="alert_bg"></div>
        </div><!-- shop-sale -->
        <!-- Begin MODULE Shop Footer -->
        @include('components.shop-footer')
        <!-- End MODULE Shop Footer -->
    </div>
    <script src="{{ mix('js/common/lib/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ mix('js/common/lib/jquery-ui.min.js') }}"></script>
    <script src="{{ mix('js/common/lib/jquery-ui-i18n.min.js') }}"></script>
    <script src="{{ mix('js/common/lib/jquery.ui.monthpicker.js') }}"></script>
    <script src="{{ mix('js/shop/onceCalender.js') }}"></script>
    <script src="{{ mix('js/shop/common.js') }}"></script>
</body>

</html>
