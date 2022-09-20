<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ</title>
</head>

<body>
<div class="container">
    <div class="l-main -info">
        <h2>お問い合わせ</h2>
        <form action="/contact" method="POST">
            @csrf
            <div class="wrap">
                <div class="select-wrap">
                    <select name="contact_category" id="contact_category">
                        <option value="">お問い合わせ種別を選択してください。</option>
                        <option
                            value="1" {{ old('contact_category') == '1' ? 'selected' : '' }}>テスト</option>
                    </select>
                </div>

                @error('contact_category')
                <p class="error">{{ $message }}</p>
                @enderror

                @if( ! \App\Auth\SellerAuth::guard()->hasUser() )
                    <input type="hidden" name="is_not_login" value="1">
                    <input type="text" name="name" placeholder="お名前" value="{{ old('name', '') }}">
                    @error('name')
                    <p class="error">{{ $message }}</p>
                    @enderror

                    <input type="email" name="email" placeholder="メールアドレス" value="{{ old('email', '') }}">
                    @error('email')
                    <p class="error">{{ $message }}</p>
                    @enderror
                @endif

                <textarea name="content" id="content" cols="30" rows="10" placeholder="お問い合わせ内容を入力してください。"
                          wrap="hard">{{ old('content', '') }}</textarea>
                @error('content')
                <p class="error">{{ $message }}</p>
                @enderror

                <p class="button01">
                    <button>問い合わせる</button>
                </p>
            </div>
        </form>
    </div>
</div>
</body>

</html>
