<x-app-layout>
    <div class="py-12 px-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex min-h-screen bg-gray-100 justify-center items-center px-4">
                <div class="w-full max-w-md">
                    <div class="bg-white shadow-md rounded-md px-8 py-12">
                        <p class="text-center text-xl">ご予約ありがとうございます</p>
                        <form class="flex justify-center mt-6" action="/" method="get">
                            @csrf
                            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">戻る</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>