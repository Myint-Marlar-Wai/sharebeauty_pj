    <h2>パスワードリセット</h2>
    <form action="/reset-password" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ request()->token }}">
        <ul class="login">
            <li>
                <input type="email" name="email" value="{{ $email ?? old('email') }}" autocomplete="email" autofocus placeholder="メールアドレス">
                @error('email')
                <p class="error">{{ $message }}</p>
                @enderror
            </li>
            <li>
                <input type="password" name="password" autocomplete="new-password" placeholder="新しいパスワード">
                @error('password')
                <p class="error">{{ $message }}</p>
                @enderror
            </li>
        </ul>
        <p>
            <button>パスワードを変更する</button>
        </p>
    </form>