@php
    use \App\Http\Routes\SellerRoutes;
@endphp
<dic>
    <div>

        <div class="mb-4 text-sm text-gray-600">
            @endforeach
            {{ 'ご登録ありがとうございます。'.PHP_EOL
                .'ご登録完了の前に、メールに記載されているリンクをクリックして、メールアドレスの確認をしてください。'.PHP_EOL
                .'もしメールが届いていない場合は、再度お送りします。' }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ '登録時に入力されたメールアドレスに、新しい確認用リンクが送信されました。' }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <button>
                        {{ '認証メールを再送する' }}
                    </button>
                </div>
            </form>

            <form method="POST" action="{{ SellerRoutes::urlLogoutPerform() }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ 'ログアウト' }}
                </button>
            </form>
        </div>
    </div>
</dic>
