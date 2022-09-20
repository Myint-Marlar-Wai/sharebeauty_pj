
<form action="/forgot-password" method="POST">
    @csrf
    <input type="email" name="email" placeholder="メールアドレス" value="{{ old('email', '') }}">
    <button type="submit">送信</button>
</form>
