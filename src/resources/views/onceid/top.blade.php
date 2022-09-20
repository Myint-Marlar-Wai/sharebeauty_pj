<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TOP</title>
</head>
<body>
<h2>ONCE EC TOP</h2>
<div>
    静的画像とテキストが入る
</div>
@auth
    {{auth()->user()->email}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
@endauth
@guest
    <div>
        <a href="/login">ログイン</a>
        <a href="{{ url('auth/google') }}">
            <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" style="margin-left: 3em;">
        </a>
    </div>
    <a href="{{ route('register') }}">会員登録</a>
@endguest
</body>
</html>
