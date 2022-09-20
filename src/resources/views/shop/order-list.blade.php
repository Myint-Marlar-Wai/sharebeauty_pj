<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>受注一覧</title>
    <link rel="stylesheet" href="{{ mix('fonts/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/common/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/shop/style.css') }}">
</head>

<body>
    <div class="wrapper">
        <!-- Begin MODULE Sub_Nav Header -->
        @include('components.sub-nav-header')
        <!-- End MODULE Sub_Nav Header -->
        <div id="order_list_content" class="order_list content">
            <div class="order_list__search_blk">
                <div class="inner">
                    <div class="order_list__search_blk__period">
                        <p class="order_list__search_blk__txt">期間</p>
                        <input type="text" id="order_start_day" class="order_list__search_blk__period__datepicker" />
                        <span>~</span>
                        <input type="text" id="order_end_day" class="order_list__search_blk__period__datepicker" />
                        <button id="order_send" type="submit" class="order_list__search_blk__period__search_icon"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                    <div class="order_list__search_blk__amount">
                        <p class="order_list__search_blk__txt">金額</p>
                        <p id="totalAmount" class="order_list__search_blk__amount_money">¥0</p>
                    </div>
                </div>
            </div>
            <input type="hidden" id="last_id" name="last_id" value="0" />
            <div id="order" class="order_list__blk"></div>
            <!--order_list__blk-->
        </div>
        <!--order_list-->
        <!-- Begin MODULE Shop Footer -->
        @include('components.shop-footer')
        <!-- End MODULE Shop Footer -->

    </div>

    <script src="{{ mix('js/common/lib/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ mix('js/common/lib/jquery-ui.min.js') }}"></script>
    <script src="{{ mix('js/shop/common.js') }}"></script>
</body>

</html>
