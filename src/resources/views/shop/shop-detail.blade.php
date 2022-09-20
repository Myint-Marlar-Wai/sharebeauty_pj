<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ショップ詳細(オーナー)</title>
    <link rel="stylesheet" href="{{ mix('fonts/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/shop/style.css') }}">
</head>

<body>
    <!--#include virtual="../component/shop-header.html" -->
    @include('components.shop-header')
    <div class="shopitem_detail detail">
        <div class="shopitem_detail__main_visual">
            <img src="../../images/img_mv.png" alt="">
        </div>
        <div class="shopitem_detail__shop_nav">
            <div class="inner shopitem_detail__shop_nav__name_list">
                <div class="shopitem_detail__shop_nav__name_list__img_blk">
                    <img src="../../images/img_mv.png" alt="">
                </div>
                <h3 class="shopitem_detail__shop_nav__name_list__name">{{ $shop->shop_name }}</h3>
            </div>
        </div>
        <div class="shopitem_detail__customer_share">
            <div class="inner">
                <h4 class="shopitem_detail__customer_share__ttl share_ttl ">ショップを運営する</h4>
                <ul class="shopitem_detail__customer_share__list">
                    <li><a href="/shop/{{ $shop->id }}/update"><i class="ico fas fa-pen"></i>ショップ編集</a></li>
                    <li><a href="template-management.html"><i class="ico fas fa-brush"></i>テンプレート</a></li>
                    <li><a href="#"><i class="ico fa-solid fa-boxes-packing"></i>商品一覧</a></li>
                    <li><a href="/shop/publish/{{ $shop->id }}"><i class="ico fa-solid fa-eye"></i>公開設定</a></li>
                    <li><a href="/shop/{{ $shop->id }}/sales"><i class="ico fa-solid fa-coins"></i>売上管理</a></li>
                    <li><a href="/order/{{ $shop->id }}"><i class="ico fa-solid fa-file-lines"></i>受注一覧</a></li>
                </ul>
            </div>
        </div>
        <div class="shopitem_detail__customer_share">
            <div class="inner">
                <h4 class="shopitem_detail__customer_share__ttl share_ttl ">お客様に共有する</h4>
                <ul class="shopitem_detail__customer_share__list">
                    <li><a href="#"><i class="ico fa-solid fa-arrow-up-right-from-square"></i>URL</a></li>
                    <li><a href="#"><i class="ico fas fa-qrcode"></i>QR</a></li>
                    <li><a href="#"><i class="ico fas fa-box-open"></i>商品</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!--shopitem_detail-->
    <!--#include virtual="../component/shop-footer.html" -->

    @include('seller.subviews.footer-shop')
    <script src="{{ mix('js/common/lib/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ mix('js/id/common.js') }}"></script>
</body>

</html>
