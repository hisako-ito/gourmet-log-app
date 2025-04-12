<x-app-layout>
    @section('title','管理画面')
    <div class="py-4 px-4">
        <div class="max-w-7xl mx-auto flex justify-center">
            <div class="w-full max-w-xl px-8">
                <div class="">
                    @if (session('message'))
                    <div class="bg-white text-black p-4 text-xl font-bold mb-4">
                        {{ session('message') }}
                    </div>
                    @endif
                </div>
                <div class="w-full flex flex-col">
                    <div>
                        <h3 class="text-xl font-bold text-center">店舗代表者登録</h3>
                    </div>
                    <form action="/admin/mypage" method="post" class="">
                        @csrf
                        <div class="mt-8 w-full">
                            <label class="font-bold">店舗代表者名</label>
                            <input type="text" name="name" class="rounded w-full" value="{{ old('name') }}">
                            <div class="text-red-500">
                                @error('name')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4 w-full">
                            <label class="font-bold">メールアドレス</label>
                            <input type="email" name="email" class="rounded w-full" value="{{ old('email') }}">
                            <div class="text-red-500">
                                @error('email')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4 w-full">
                            <label class="font-bold">パスワード</label>
                            <input type="password" name="password" class="rounded w-full">
                            <div class="text-red-500">
                                @error('password')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4 w-full">
                            <label class="font-bold">パスワード確認</label>
                            <input type="password" name=" password_confirmation" class="rounded w-full">
                        </div>
                        <div class="flex justify-center mt-8">
                            <button class="px-4 py-2 bg-blue-600 text-white rounded cursor-pointer hover:bg-blue-700" type="submit">登録する</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>