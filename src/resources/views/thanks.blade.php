<x-app-layout>
    @section('title','会員登録完了')
    <div class="flex min-h-screen bg-gray-100 justify-center items-center p-4">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-md rounded-md p-8">
                <h2 class="text-center text-xl font-bold mb-6">会員登録ありがとうございます</h2>
                <form method="POST" action="{{ route('login') }}" class="p-6 pt-6">
                    @csrf
                    <div class="flex justify-center mt-6">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                            ログイン
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>