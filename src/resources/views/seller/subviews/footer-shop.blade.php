@php
    declare(strict_types=1);
    use App\Constants\Views\BladeConstants as Constants;
    use App\Http\Routes\SellerRoutes;
    use App\Http\Routes\Enums\ShopFooterActiveTab;
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\ViewResource);
    $footerShopActiveTab = SellerRoutes::getShopFooterActiveTab();
@endphp

    <!-- Begin MODULE Shop Footer -->
<div class="shop_footer">
    <div class="inner">
        {{-- TODO active --}}
        <a href="{{ SellerRoutes::urlShops() }}"
            @class([
                'active' => $footerShopActiveTab === ShopFooterActiveTab::Shops,
            ])
        ><i class="fas fa-home"></i>{{ 'ショップ一覧' }}</a>

        <a href="{{ SellerRoutes::urlSales() }}"
            @class([
                'active' => $footerShopActiveTab === ShopFooterActiveTab::Sales,
            ])
        ><i class="fas fa-coins"></i>{{ '売上管理' }}</a>

        <a href="{{ SellerRoutes::urlSetting() }}"
            @class([
                'active' => $footerShopActiveTab === ShopFooterActiveTab::Settings,
            ])
        ><i class="fas fa-cog"></i>{{ '設定' }}</a>

        <a href="{{ SellerRoutes::urlSupport() }}"
            @class([
                'active' => $footerShopActiveTab === ShopFooterActiveTab::Support,
            ])
        ><i class="fas fa-user"></i>{{ 'サポート' }}</a>
    </div>
</div>
<!-- End MODULE Shop Footer -->
