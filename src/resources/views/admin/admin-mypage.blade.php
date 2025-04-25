<x-app-layout>
    @section('title','管理画面')
    <div class="px-4 py-4
    ">
        <div class="max-w-7xl mx-auto">
            <div class="">
                @if (session('message'))
                <div class="bg-white text-black p-4 text-xl font-bold mb-4">
                    {{ session('message') }}
                </div>
                @endif
            </div>
            <h2 class="text-xl font-bold w-full my-2">{{ $adminUser->name }}様の管理画面</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="p-8">
                    <div class="flex items-center mb-4">
                        <h3 class="text-xl font-bold text-center">利用者宛メール送信フォーム</h3>
                    </div>
                    <form method="POST" action="{{ route('admin.sendNotice') }}">
                        @csrf
                        <div class="mt-2 w-full">
                            <label class="font-bold">件名</label>
                            <input type="text" name="subject" class="rounded w-full">
                            <div class="text-red-500">
                                @error('subject')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mt-2 w-full">
                            <label class="font-bold">本文</label>
                            <textarea name="body" class="block w-full h-[300px]"></textarea>
                            <div class="text-red-500">
                                @error('body')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="flex justify-center mt-8">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded cursor-pointer hover:bg-blue-700">送信する</button>
                        </div>
                    </form>
                </div>
                <div class="p-8">
                    <div class="flex items-center mb-4">
                        <h3 class="text-xl font-bold text-center">店舗代表者登録フォーム</h3>
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
                        <div class="flex justify-center mt-8">
                            <button class="px-4 py-2 bg-blue-600 text-white rounded cursor-pointer hover:bg-blue-700" type="submit">登録する</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>