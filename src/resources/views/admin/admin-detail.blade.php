<x-app-layout>
    @section('title','店舗詳細')
    <div class="py-4 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="w-full flex justify-center">
                <div class="w-full max-w-xl px-8">
                    <div class="flex items-center mb-4">
                        <a href="{{ route('home') }}" class="mr-2">
                            <button class="bg-white text-xl px-3 py-1 rounded shadow-md"><i class="fa-solid fa-chevron-left"></i></button></a><span class="text-xl font-bold">{{ $shop->name }}</span>
                    </div>
                    <img src="{{ asset('storage/' . $shop->image) }}" alt="店舗画像" class="w-full h-[300px] object-cover rounded shadow-md mb-4" />
                    <p class="text-gray-700 mb-2">#{{ $shop->area->name }} #{{ $shop->category->content }}</p>
                    <p class="text-gray-800 leading-relaxed">{{ $shop->description }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>