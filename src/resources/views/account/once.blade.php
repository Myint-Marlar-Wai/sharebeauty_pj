
<form action="/setting/once" method="POST">
    @csrf
    <ul>
        <li>
            <input type="email" name="email" value="{{ $email ?? old('email') }}" autocomplete="email" autofocus placeholder="ONCE ID">
            @error('email')
            <p class="error">
                {{ $message }}
            </p>
            @enderror
        </li>
        <button>送信</button>
    </ul>
</form>
