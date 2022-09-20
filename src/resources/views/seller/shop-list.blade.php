@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    use \App\Http\Routes\SellerRoutes;
@endphp
@extends('seller.layouts.base-shop')
@prepend(Constants::STACK_SCRIPTS)
    <script src="{{ mix('js/ec/qrcode.js') }}"></script>
    <script src="{{ mix('js/ec/jquery.qrcode.js') }}"></script>
    <script src="{{ mix('js/ec/customqrcode.js') }}"></script>
@endprepend
@section(Constants::CONTENT)
    <h1 class="shop_ttl">ショップ一覧</h1>
    <div class="shop_list content_bg">
        @foreach ($shops as $shop)
            <div class="shopitem_detail">
                <div class="shopitem_detail__main_visual">
                    {{-- TODO Shop Id --}}
                    <a href="{{ SellerRoutes::urlShopDetail(\App\Data\Shop\ShopId::from($shop->id)) }}"><img
                            src="images/img_mv.png" alt=""></a>
                </div>
                <div class="shopitem_detail__shop_nav">
                    <div class="inner shopitem_detail__shop_nav__name_list">
                        <div class="shopitem_detail__shop_nav__name_list__img_blk">
                            <i class="fa-solid fa-image"></i>
                        </div>
                        <h3 class="shopitem_detail__shop_nav__name_list__name">{{ $shop->shop_name }}</h3>
                    </div>
                </div>
                <div class="shopitem_detail__customer_share">
                    <div class="inner">
                        <h4 class="shopitem_detail__customer_share__ttl share_ttl ">お客様に共有する</h4>
                        <ul class="shopitem_detail__customer_share__list">
                            <li>
                                <button type="button" id="listcopy1"><i
                                        class="ico fa-solid fa-arrow-up-right-from-square"></i>URL
                                </button>
                            </li>
                            <li><a href="#" class="url" data-target="qrcode" data-url="https://www.google.com"><i
                                        class="ico fas fa-qrcode"></i>QR</a>
                                <div class="alert_modal shop_modal qrcode">
                                    <div class="alert_modal__popup">
                                        <img alt="">
                                    </div>
                                </div>
                            </li>
                            <li><a href="#"><i class="ico fas fa-box-open"></i>商品</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="shop_btn_group detail inner">
            <a href="#" class="shop_btn"><span>新しくショップを追加する</span><i class="fas fa-angle-double-right"></i></a>
        </div>
    </div>

@endsection
