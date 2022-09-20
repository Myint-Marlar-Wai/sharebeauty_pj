<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>仮登録完了</title>
</head>
<body>
<h2>仮登録完了</h2>
<div>
    メール確認しなさい
    <div>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <button>
                    {{ __('Resend Verification Email') }}
                </button>
            </div>
        </form>
    </div>
    <div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">ログイン画面に戻る</button>
        </form>
    </div>
</div>
</body>
</html>
