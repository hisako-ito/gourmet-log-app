<x-app-layout>
    <div class="py-12 px-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($shops as $shop)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset($shop->image) }}" alt="店舗画像" class="w-full h-48 object-cover" />
                    <div class="p-4">
                        <p class="text-lg font-semibold">{{ $shop->name }}</p>
                        <p class="text-sm text-gray-600">#{{ $shop->category->content }} #{{ $shop->area->name }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <a href="/detail/{{ $shop->id }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">詳しく見る</a>
                            <button><i class="fa-solid fa-heart"></i></button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-4 flex justify-center space-x-2">
                {{ $shops->appends(request()->query())->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</x-app-layout>