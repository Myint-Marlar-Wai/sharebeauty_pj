<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <title>公開設定(オーナー)｜ 公開/非公開/休止</title>
    <link rel="stylesheet" href="{{ mix('fonts/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/shop/style.css') }}">
</head>

<body>
    <div class="wrapper">
        <!-- Begin MODULE Sub_Nav Header -->
        <div class="sub_nav">
            <div class="inner">
                <p><a href="javascript:history.back()"><i class="fa-solid fa-angles-left left_arrow"></i><span>Lano by
                            HAIR</span></a></p>
            </div>
        </div>
        <!-- End MODULE Sub_Nav Header -->
        <div class="shop_content content">
            <div class="inner">
                <div class="publishing-settings">
                    <h3 class="title publishing-settings__ttl">公開設定</h3>
                    <p class="publishing-settings__txt">
                        ショップを公開するためには、プロフィール登録と1つ以上の商品登録が必要となります。
                    </p>
                    <ul class="publishing-settings__alert">
                        <li>・&nbsp;プロフィール登録 ×</li>
                        <li>・&nbsp;商品登録 ×</li>
                    </ul>
                    <ul class="publishing-settings__btn__list">
                        <li>
                            <button type="submit" class="action_btn" data-modal="public">公開</button>
                            <p class="action_desc">
                                ショップを公開します。商品を購入できるようになります。
                            </p>
                        </li>
                        <li>
                            <button type="submit" class="action_btn" data-modal="private">非公開</button>
                            <p class="action_desc">
                                ショップを非公開します。
                                フランチャイズ店舗もすべて非公開となります。
                            </p>
                        </li>
                        <li>
                            <button type="submit" class="action_btn" data-modal="pause">休止</button>
                            <p class="action_desc">
                                ショップを休止します。
                                ショップは休止中の表示となり商品の購入ができなくなります。
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="alert_modal" id="public">
                <form class="alert_modal__form" action="/shop/publish/{{ $shop->id }}" method="POST">
                    @csrf
                    <a href="javascript:void(0)" class="alert_modal__form__close">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                    <h3 class="alert_modal__form__ttl">ショップを公開します</h3>
                    <p class="alert_modal__form__txt">
                        作成したショップを公開し、お客様が購入できるようになります。
                        このまま公開する場合は「公開」、やめる場合は「キャンセル」を押してください。
                    </p>
                    <div class="alert_modal__form__buttons">
                        <button type="submit" class="btn alert_cancel_btn">キャンセル</button>
                        <button type="submit" class="btn alert_action_btn">公開</button>
                    </div>
                    <input type="hidden" name="pattern" value="1">
                </form>
            </div>
            <div class="alert_modal" id="private">
                <form class="alert_modal__form" action="/shop/publish/{{ $shop->id }}" method="POST">
                    @csrf
                    <a href="javascript:void(0)" class="alert_modal__form__close">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                    <h3 class="alert_modal__form__ttl">ショップを非公開します</h3>
                    <p class="alert_modal__form__txt">
                        作成したショップを公開し、お客様が購入できるようになります。
                        このまま公開する場合は「公開」、やめる場合は「キャンセル」を押してください。
                    </p>
                    <div class="alert_modal__form__buttons">
                        <button type="submit" type="submit" class="btn alert_cancel_btn">キャンセル</button>
                        <button type="submit" type="submit" class="btn alert_action_btn">非公開</button>
                    </div>
                    <input type="hidden" name="pattern" value="0">
                </form>
            </div>
            <div class="alert_modal" id="pause">
                <form class="alert_modal__form" action="/shop/publish/{{ $shop->id }}" method="POST">
                    @csrf
                    <a href="javascript:void(0)" class="alert_modal__form__close">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                    <h3 class="alert_modal__form__ttl">ショップを休止します</h3>
                    <p class="alert_modal__form__txt">
                        作成したショップを公開し、お客様が購入できるようになります。
                        このまま公開する場合は「公開」、やめる場合は「キャンセル」を押してください。
                    </p>
                    <div class="alert_modal__form__buttons">
                        <button type="submit" class="btn alert_cancel_btn">キャンセル</button>
                        <button type="submit" class="btn alert_action_btn">休止</button>
                    </div>
                    <input type="hidden" name="pattern" value="2">
                </form>
            </div>
        </div>
        <!--shop_content-->
        <!-- Begin MODULE Shop Footer -->
        @include('components.shop-footer')
        <!-- End MODULE Shop Footer -->
    </div>
    <script src="{{ mix('js/common/lib/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ mix('js/shop/common.js') }}"></script>
</body>

</html>
