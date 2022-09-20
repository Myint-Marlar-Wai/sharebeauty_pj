<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ショップ作成(オーナー)</title>
    <link rel="stylesheet" href="{{ mix('fonts/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/common/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ mix('css/shop/style.css') }}">
    <link rel="stylesheet" href="{{ mix('css/common/croppie.css') }}">
</head>

<body>
    <!--#include virtual="../component/shop-header.html" -->
    @include('components.shop-header')
    @if (isset($message))
        {{ dd($message) }}
    @endif
    <div class="shop_create shop_content">
        <div class="inner content_bg">
            <h2 class="shop_create__ttl">ショップ作成</h2>
            <form class="shop_create__form" action="/shop/store" method="POST">
                @csrf
                <div id="disp_shop_name" class="shop_create__form__data__flex">
                    <label for="shop_create_name" class="label">表示ショップ名 </label>
                    <div class="field shop_create__form__data__flex__field">
                        <input type="text" name="shop_create_name" id="shop_create_name">
                        @error('shop_create_name')
                        <p class="error">
                            {{ $message }}
                        </p>
                        @enderror
                        <button type="submit" class="btn shop_create__form__data__flex__submit">重複チェック</button>
                    </div>
                </div>
                <div class="shop_create__form__data__flex">
                    <label for="shop_create_result" class="label">URLショップ名<span>（半角英数）</span></label>
                    <div class="field shop_create__form__data__flex__field">
                        <input type="text" name="shop_create_result" id="shop_create_result">
                        @error('shop_create_result')
                        <p class="error">
                            {{ $message }}
                        </p>
                        @enderror
                        <button type="submit" class="btn shop_create__form__data__flex__submit">重複チェック</button>
                    </div>
                </div>
                <div>
                    <label for="acc_change_area" class="label">ショップ紹介文 </label>
                    <textarea name="shop_introduction" id="acc_change_area" class="shop_create__form__data__area"></textarea>
                    @error('shop_introduction')
                    <p class="error">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div>
                    <label class="label">ショップイメージ1 </label>
                    <div class="custom_upload">
                        <img src="" alt="" class="img_input" id="upload_1_img">
                        <label for="upload_1" class="upload_button" id="upload_1_btn">
                            <input type="file" name="image1" id="upload_1" class="upload_input" onclick="this.value = null"
                                multiple hidden>
                            <span>画像を読み込む</span>
                        </label>
                        <input type="button" value="x" class="image_remove_btn" id="upload_1_remove" />
                    </div>
                </div>
                <div>
                    <label class="label">ショップイメージ2 </label>
                    <div class="custom_upload">
                        <img src="" alt="" class="img_input" id="upload_2_img">
                        <label for="upload_2" class="upload_button" id="upload_2_btn">
                            <input type="file" name="image2" id="upload_2" class="upload_input" onclick="this.value = null"
                                multiple hidden>
                            <span>画像を読み込む</span>
                        </label>
                        <input type="button" value="x" class="image_remove_btn" id="upload_2_remove" />
                    </div>
                </div>
                <button type="submit" class="shop_create__form__btn btn01">ONCE ショップを作成する</button>
            </form>
        </div>
    </div>
    <!--shop_create-->
    <!--#include virtual="../component/shop-footer.html" -->
    @include('components.shop-footer')
    <script src="{{ mix('js/common/lib/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ mix('js/common/lib/bootstrap.js') }}"></script>
    <script src="{{ mix('js/common/lib/croppie.js') }}"></script>
    <script src="{{ mix('js/shop/common.js') }}"></script>
</body>

</html>
