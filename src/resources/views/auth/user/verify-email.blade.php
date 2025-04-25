<x-guest-layout>
    @section('title','メールアドレス認証のご案内')
    <div class="p-4">
        <div class="flex min-h-screen bg-gray-100 justify-center items-center px-4">
            <div class="w-full max-w-md">
                <div class="bg-white shadow-md rounded-md px-8 py-12">
                    <p class="text-center text-xl">ご登録ありがとうございます！</p>
                    <p>
                        ご利用を開始する前に、メールアドレスの確認をお願いいたします。</p>
                    <p>確認用リンクをメールでお送りしましたので、クリックして認証してください。<br />もし届いていない場合は、再送も可能です。</p>
                    @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        新しい確認リンクを登録時のメールアドレスに送信しました。
                    </div>
                    @endif
                    <div class="mt-4 flex items-center justify-center">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <div>
                                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    確認メールを再送する
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>