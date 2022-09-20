<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ショップ情報変更(オーナー)</title>
    <link rel="stylesheet" href="{{ mix('fonts/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/shop/style.css') }}">
</head>

<body>
    <div class="wrapper">
        <!-- Begin MODULE Sub_Nav Header -->
        @include('components.sub-nav-header')
        <!-- End MODULE Sub_Nav Header -->
        <div class="shop_change shop_content content">
            <div class="inner">
                <h2 class="shop_ttl">ショップ作成</h2>
                <p class="shop_create__txt">Oral care gel Applemint（オーラルケアジェル　アップルミント）Oral care gel Applemint（オーラルケア</p>
                <form class="shop_create__form" action="/shop/{{ $shop->id }}/update"  method="POST">
                    @csrf
                    <div class="shop_create__form__flex field">
                        <h3 class="shop_create__ttl">表示ショップ名<span>必須</span></h3>
                        <label for="shop_create_name" class="label">サブテキスト </label>
                        <input type="text" name="shop_create_name" id="shop_create_name" value="{{ $shop->display_shop_id }}">
                        @error('shop_create_name')
                        <p class="error">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="shop_create__form__flex field">
                        <h3 class="shop_create__ttl">URLショップ名（半角英数字）<span>必須</span></h3>
                        <label for="shop_create_name" class="label">サブテキスト</label>
                        <div class="shop_create__form__flex__field">
                            <a href="">https:spooon.com/</a><input type="text" name="shop_create_result"
                                id="shop_create_result" value="{{ $shop->shop_name }}">
                        </div>
                    </div>
                    <div class="shop_create__form__flex field">
                        <h3 class="shop_create__ttl">ショップ紹介文<span>必須</span></h3>
                        <label for="acic_change_area" class="label">サブテキスト </label>
                        <textarea name="shop_introduction" id="acc_change_area" class="shop_create__form__flex__area"
                            placeholder="{{ $shop->shop_text }}"></textarea>
                            @error('shop_introduction')
                            <p class="error">
                                {{ $message }}
                            </p>
                            @enderror
                    </div>
                    <div>
                        <label class="label">ショップイメージ１<span>任意</span></label>
                        <div class="custom_upload">
                            <img alt="" id="shop_name_1_img">
                            <label for="shop_name_1" class="upload_button" id="shop_name_1_btn">
                                <img src="../../images/ico_plus_black.png" alt="">
                                <input type="file" name="" id="shop_name_1" class="upload_input"
                                    onclick="this.value = null" multiple hidden>
                                <span>画像を読み込む</span>
                            </label>
                            <i class="fa-solid fa-circle-xmark image_remove_btn" id="shop_name_1_remove"
                                wfd-invisible="true"></i>
                        </div>
                    </div>
                    <div>
                        <label class="label">ショップイメージ２<span>任意</span></label>
                        <div class="custom_upload">
                            <img alt="" id="shop_name_2_img">
                            <label for="shop_name_2" class="upload_button" id="shop_name_2_btn">
                                <img src="../../images/ico_plus_black.png" alt="">
                                <input type="file" name="" id="shop_name_2" class="upload_input"
                                    onclick="this.value = null" multiple hidden>
                                <span>画像を読み込む</span>
                            </label>
                            <i class="fa-solid fa-circle-xmark image_remove_btn" id="shop_name_2_remove"
                                wfd-invisible="true"></i>
                        </div>
                    </div>
                    <button type="submit" class="shop_create__form__btn btn01"><i
                            class="fa-solid fa-file-circle-check"></i>作成</button>
                </form>
            </div>
        </div>
        <!--shop_change-->
        <!-- Begin MODULE Shop Footer -->
        @include('components.shop-footer')
        <!-- End MODULE Shop Footer -->
    </div>
    <script src="{{ mix('js/common/lib/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ mix('js/shop/common.js') }}"></script>
</body>

</html>
