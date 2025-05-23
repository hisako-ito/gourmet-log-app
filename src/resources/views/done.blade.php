<x-app-layout>
    @section('title','予約完了')
    <div class="p-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex min-h-screen bg-gray-100 justify-center items-center px-4">
                <div class="w-full max-w-md">
                    <div class="bg-white shadow-md rounded-md px-8 py-12">
                        <p class="text-center text-xl">ご予約ありがとうございます</p>
                        <p class="text-center text-sm mt-2">予約確定メールをお送りしました</p>
                        <p class="text-center text-sm mt-2">当日、来店されましたら、<br />メールに記載されているQRコードを店員にお見せください</p>
                        <div class="flex justify-center mt-6">
                            <a href="{{ route('user.detail', ['shop_id' => $shop->id]) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                戻る
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>