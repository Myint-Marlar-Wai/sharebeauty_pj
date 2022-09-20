<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
    <title>アカウント設定（ID、パスワード）</title>
    <link rel="stylesheet" href="{{ mix('fonts/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/id/style.css') }}">

</head>

<body>
<div class="wrapper">
    <!-- Begin MODULE ID Header -->
    <header class="header">
        <div class="inner">
            <p class="header__title"><a href="#"><img src="../../images/img_logo.png" alt="spooon!"></a></p>
        </div>
    </header>
    <!-- End MODULE ID Header -->
    <div class="acc_setting content_bg">
        <div class="inner">
            <h2 class="acc_setting__ttl title">アカウント設定</h2>
            <ul class="acc_setting__btn_list">
                <li>
                    <a href="/setting/once" class="btn btn01 acc_setting__btn_list__btn">ONCE ID 変更</a>
                </li>
                <li>
                    <a href="{{ \App\Http\Routes\SellerRoutes::urlPasswordChange() }}" class="btn btn01 acc_setting__btn_list__btn">パスワード変更</a>
                </li>
                <li>
                    <a href="/setting/profile" class="btn btn01 acc_setting__btn_list__btn">プロフィール更新</a>
                </li>
                <li>
                    <a href="/setting/bank" class="btn btn01 acc_setting__btn_list__btn">口座情報更新</a>
                </li>
                <li>
                    <form action="{{ \App\Http\Routes\SellerRoutes::urlLogoutPerform() }}" method="post">
                        @csrf
                        <input type="submit" value="ログアウト" class="btn btn01 acc_setting__btn_list__btn" />
                    </form>
                </li>
            </ul>
            <h2 class="acc_setting__ttl title">運営者情報</h2>
            <ul class="acc_setting__operator">
                <li><a href="#">運営会社</a></li>
                <li><a href="#">利用規約</a></li>
                <li><a href="#">プライバシーポリシー</a></li>
                <li><a href="#">お問い合わせ</a></li>
            </ul>
        </div>
    </div><!-- /.acc_setting -->
    <!-- Begin MODULE ID Footer -->
    <footer class="footer">
        <div class="inner">
            <div class="footer__banner">
                <p class="footer__banner__txt">セールスコピー<br>マイクロテキスト</p>
                <a href="#" class="footer__banner__logo"><img src="../../images/img_logo.png" alt="spooon!"></a>
            </div>
        </div>
        <div class="footer__nav">
            <div class="inner">
                <ul class="footer__nav__list">
                    <li><a href="#">利用規約</a></li>
                    <li><a href="#">プライバシーポリシー</a></li>
                    <li><a href="#"> お問合せ</a></li>
                    <li><a href="#">運営会社</a></li>
                </ul>
                <p class="footer__nav__copy_txt">
                    © 2022 ONCE EC
                </p>
            </div>
        </div>
    </footer>
    <!-- End MODULE ID Footer -->
</div>
<script src="{{ mix('js/common/lib/jquery-3.6.0.min.js') }}"></script>
<script src="{{ mix('js/id/common.js') }}"></script>

</body>

</html>
