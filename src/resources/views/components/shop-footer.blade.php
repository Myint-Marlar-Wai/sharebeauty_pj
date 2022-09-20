<div class="shop_footer">
    <div class="inner">
        <a href="/shop" 
        @if (isset($shopView))
            class="active"
        @endif>
        <i class="fas fa-home"></i>ショップ一覧</a>
        <a href="/once/{{ $once->id }}/sales"
        @if (isset($saleView))
            class="active"
        @endif>
        <i class="fas fa-coins"></i>売上管理</a>
        <a href="/setting"
        @if (isset($settingView))
            class="active"
        @endif>
        <i class="fas fa-cog"></i>設定</a>
        <a href="#"
        @if (isset($supportView))
            class="active"
        @endif>
        <i class="fas fa-user"></i>サポート</a>
    </div>
</div>
