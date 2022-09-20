
<form action="/setting/bank" method="POST">
    @csrf
    <ul>
        <li>
            <input type="text" name="bank_code" value="{{ $bank_code ?? old('bank_code') }}" autocomplete="bank_code" autofocus placeholder="金融機関コード">
            @error('bank_code')
            <p class="error">
                {{ $message }}
            </p>
            @enderror
        </li>
        <li>
            <input type="text" name="bank_name" value="{{ $bank_name ?? old('bank_name') }}" autocomplete="bank_name" autofocus placeholder="銀行名">
            @error('bank_name')
            <p class="error">
                {{ $message }}
            </p>
            @enderror
        </li>
        <li>
            <input type="text" name="branch_code" value="{{ $branch_code ?? old('branch_code') }}" autocomplete="branch_code" autofocus placeholder="支店コード">
            @error('branch_code')
            <p class="error">
                {{ $message }}
            </p>
            @enderror
        </li>
        <li>
            <input type="text" name="branch_name" value="{{ $branch_name ?? old('branch_name') }}" autocomplete="branch_name" autofocus placeholder="支店名">
            @error('branch_name')
            <p class="error">
                {{ $message }}
            </p>
            @enderror
        </li>
        <li>
            <input type="radio" name="account_type" value="0" checked>
            <label for="none">
                普通
            </label>
            @error('account_type')
            <p class="error">
                {{ $message }}
            </p>
            @enderror
        </li>
        <li>
            <input type="radio" name="account_type" value="1">
            <label for="women">
                当座
            </label>
            @error('account_type')
            <p class="error">
                {{ $message }}
            </p>
            @enderror
        </li>
        <li>
            <input type="text" name="account_number" value="{{ $account_number ?? old('account_number') }}" autocomplete="account_number" autofocus placeholder="口座番号">
            @error('account_number')
            <p class="error">
                {{ $message }}
            </p>
            @enderror
        </li>
        <li>
            <input type="text" name="account_name" value="{{ $account_name ?? old('account_name') }}" autocomplete="account_name" autofocus placeholder="口座名義">
            @error('account_name')
            <p class="error">
                {{ $message }}
            </p>
            @enderror
        </li>
        <li>
            <input type="text" name="account_kana" value="{{ $account_kana ?? old('account_kana') }}" autocomplete="account_kana" autofocus placeholder="口座名義かな">
            @error('account_kana')
            <p class="error">
                {{ $message }}
            </p>
            @enderror
        </li>
        <li>
            <textarea name="account_memo" maxlength="400" value="{{ $account_memo ?? old('account_memo') }}" autocomplete="account_memo" placeholder="備考"></textarea>
            @error('account_memo')
            <p class="error">
                {{ $message }}
            </p>
            @enderror
        </li>
        <button type="submit">送信</button>
    </ul>
</form>
