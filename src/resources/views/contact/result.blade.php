<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ完了 ｜ PLUSEEK</title>
    <link rel="stylesheet" href="{{ mix('/css/m&a_service/style.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/m&a_service/contact.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@500;700&display=swap" rel="stylesheet">
</head>

<body>
    @include('common.header.service-header')
    <main class="single-layout">
        <h2>お問い合わせありがとうございます。</h2>
        <p class="read">
            お問い合わせを受け付けました。
        </p>
        <p class="read">
            折り返し、担当者より<br class="sp">ご連絡いたしますので、<br>
            恐れ入りますが、<br class="sp">しばらくお待ちください。
        </p>


        <p class="button01"><a href="/">トップページに戻る</a></p>
    </main>
    @include('common.footer.service-footer')
</body>

</html>
