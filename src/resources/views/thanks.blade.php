<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 justify-center items-center px-4">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-md rounded-md p-8">
                <h2 class="text-center text-xl font-bold mb-6">会員登録ありがとうございます</h2>
                @csrf
                <div class="text-center">
                    <a href="{{ route('home') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition rounded-md">
                        ログイン
                    </a>

                </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>