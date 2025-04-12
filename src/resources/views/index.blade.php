<x-app-layout>

    @section('title','店舗一覧')

    @section('css')
    <link rel="stylesheet" href="{{ asset('/css/navigation.css')  }}">
    @endsection

    <div class="py-4 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($shops as $shop)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('storage/' . $shop->image) }}" alt="店舗画像" class="w-full h-48 object-cover" />
                    <div class="p-4">
                        <p class="text-lg font-semibold">{{ $shop->name }}</p>
                        <p class="text-sm text-gray-600">#{{ $shop->category->content }} #{{ $shop->area->name }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <a href="/detail/{{ $shop->id }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">詳しく見る</a>
                            <div class="">
                                <form action="{{ $shop->liked() ? '/shop/unlike/'.$shop->id : '/shop/like/'.$shop->id  }}" method="post" class="" id="like__form">
                                    @csrf
                                    <button><i class="fa-2xl fa-heart {{ $shop->liked() ? 'fa-sharp fa-solid text-red-500' : 'fa-sharp fa-solid text-gray-300' }}"></i></button>
                                    <p class="text-center">{{$shop->likeCount()}}</p>
                                </form>
                            </div>
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