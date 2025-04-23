<x-app-layout>
    @section('title','支払完了')
    <div class="p-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex min-h-screen bg-gray-100 justify-center items-center px-4">
                <div class="w-full max-w-md">
                    <div class="bg-white shadow-md rounded-md px-8 py-12">
                        <p class="text-center text-xl">お支払いいただき、ありがとうございます</p>
                        <p class="text-center text-xl">当日、お待ちしております</p>
                        <p class="text-center text-sm">コースまたは人数の変更がある場合、直接店舗までご連絡ください</p>
                        <form class="flex justify-center mt-6" action="/mypage" method="get">
                            @csrf
                            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">戻る</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>