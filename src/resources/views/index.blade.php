<x-app-layout>

    @section('title','店舗一覧')

    @section('css')
    <link rel="stylesheet" href="{{ asset('/css/navigation.css')  }}">
    @endsection

    <div x-data="{ showModal: false, selectedShopId: null }">
        <div class="py-4 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="">
                    @if (session('message'))
                    <div class="bg-white text-black p-4 text-xl font-bold mb-4">
                        {{ session('message') }}
                    </div>
                    @endif
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($shops as $shop)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('storage/' . $shop->image) }}" alt="店舗画像" class="w-full h-48 object-cover" />
                        <div class="p-4">
                            <p class="text-lg font-semibold">{{ $shop->name }}</p>
                            <p class="text-sm text-gray-600">#{{ $shop->category->content }} #{{ $shop->area->name }}</p>
                            <div class="mt-4 flex justify-between items-center">
                                @if (Auth::guard('web')->check())
                                <a href="{{ route('user.detail', ['shop_id' => $shop->id]) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">詳しく見る</a>
                                @elseif(Auth::guard('owner')->check())
                                <a href="{{ route('owner.detail', ['shop_id' => $shop->id]) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">詳しく見る</a>
                                @elseif(Auth::guard('admin')->check())
                                <a href="{{ route('admin.detail', ['shop_id' => $shop->id]) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">詳しく見る</a>
                                @endif
                                @if ($shop->canUserReview(auth()->id()))
                                <button
                                    @click="selectedShopId = {{ $shop->id }}; showModal = true"
                                    class="bg-blue-500 text-white px-3 py-1 rounded mt-2">
                                    評価する
                                </button>
                                @endif
                                <div class="">
                                    <form action="{{ $shop->liked() ? '/shop/unlike/'.$shop->id : '/shop/like/'.$shop->id  }}" method="post" id="like__form">
                                        @csrf
                                        <button type="submit"
                                            @if(Auth::guard('owner')->check() || Auth::guard('admin')->check()) disabled @endif>
                                            <i class="fa-2xl fa-heart {{ $shop->liked() ? 'fa-sharp fa-solid text-red-500' : 'fa-sharp fa-solid text-gray-300' }}"></i>
                                        </button>
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

                <div x-show="showModal"
                    style="display: none;"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div @click.away="showModal = false" class="bg-white p-6 rounded w-full max-w-md relative">
                        <button @click="showModal = false" class="absolute top-2 right-2 text-gray-500 text-2xl">&times;</button>
                        <div class="text-center">
                            <h2 class="text-xl font-bold">ご来店いただき、ありがとうございました。</h2>
                            <p class="mt-2">よろしければ店舗の評価をお願いいたします。</p>
                        </div>
                        <form method="POST" action="{{ route('reviews.store') }}">
                            @csrf
                            <input type="hidden" name="shop_id" :value="selectedShopId">

                            <input type="hidden" name="rating" value="0">
                            <div class="star-rating">
                                @for ($i = 5; $i >= 1; $i--)
                                <input class="hidden" type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}">
                                <label class="star" for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                @endfor
                            </div>

                            <label for="comment" class="block text-sm font-medium">コメント</label>
                            <textarea name="comment" rows="4" class="border w-full p-2 mb-3"></textarea>
                            <div class="text-center">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">送信</button>
                            </div>
                            <div class="mt-4 text-center">
                                <template x-if="selectedShopId">
                                    <a :href="`/detail/${selectedShopId}`" class="text-blue-600 underline" target="_blank">
                                        店舗詳細を見る
                                    </a>
                                </template>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>