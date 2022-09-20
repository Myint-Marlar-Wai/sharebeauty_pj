<h2>パスワード変更</h2>
<form action="/setting/password" method="POST">
    @csrf
    <ul class="login">
        <li>
            <input type="password" name="password" autocomplete="password" placeholder="現在のパスワード">
            @error('password')
            <p class="error">{{ $message }}</p>
            @enderror
        </li>
        <li>
            <input type="password" name="new_password" autocomplete="new__password" placeholder="新しいパスワード">
            @error('new_password')
            <p class="error">{{ $message }}</p>
            @enderror
        </li>
    </ul>
    <p>
        <button>パスワードを変更する</button>
    </p>
</form>