<x-app-layout>
    @section('title','マイページ')
    <div class="py-4 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="">
                @if (session('message'))
                <div class="bg-white text-black p-4 text-xl font-bold">
                    {{ session('message') }}
                </div>
                @endif
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-6">
                    <h2 class="text-xl font-bold">予約状況</h2>
                    @forelse ($reservations as $index => $reservation)
                    <div class="bg-blue-600 text-white rounded-lg shadow-md p-8 relative">
                        <form action="/reservation/delete/{{ $reservation->id }}" method="post" class="reservation-box">
                            @csrf
                            <div class="flex justify-between">
                                <div class="flex items-center"><i class="fa-regular fa-clock text-xl"></i>
                                    <span class="ml-2">
                                        {{ $index === 0 ? '予約1' : '予約' . ($index + 1) }}</span>
                                </div>
                                <div class="">
                                    <button type="submit" class="close-btn text-white text-xl font-bold">
                                        <i class="fa-regular fa-circle-xmark"></i>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ $reservation->id }}">
                        </form>

                        <form action="/reservation/update/{{ $reservation->id }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $reservation->id }}">

                            <div class="mt-4 flex items-center">
                                <label class="w-24 text-sm h-10 flex items-center">Shop</label>
                                <input class="h-10 px-3 py-[5px] text-sm border border-gray-300 rounded w-full" value="{{ $reservation->shop->name }}" readonly>
                            </div>
                            <div class="mt-2 flex items-center">
                                <label class="w-24 text-sm h-10 flex items-center">Date</label>
                                <input style="color: black;" class="h-10 px-3 py-[5px] text-sm border border-gray-300 rounded w-full" name="date" type="date" value="{{ $reservation->date }}">
                            </div>
                            <div class="mt-2 flex items-center">
                                <label class="w-24 text-sm h-10 flex items-center">Time</label>
                                <input style="color: black;" class="h-10 px-3 py-[5px] text-sm border border-gray-300 rounded w-full" name="time" value="{{ $reservation->time }}" type="time" min="17">
                            </div>
                            <div class="mt-2 flex items-center">
                                <label class="w-24 text-sm h-10 flex items-center">Number</label>
                                <div class="flex items-center h-10 w-full">
                                    <input
                                        style="color: black;" class="w-16 h-full px-2 text-sm border border-gray-300 rounded text-right"
                                        name="number"
                                        value="{{ $reservation->number }}"
                                        type="number"
                                        min="1">
                                    <span class="ml-1 text-sm">人</span>
                                </div>
                            </div>
                            <div class="flex justify-center mt-6">
                                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md transition">
                                    予約内容変更
                                </button>
                            </div>
                        </form>
                    </div>
                    @empty
                    <div class="bg-blue-600 text-white rounded-lg shadow-md p-6 min-h-[200px] flex items-center justify-center">
                        現在、予約はありません。
                    </div>
                    @endforelse
                </div>

                <div class="flex flex-col gap-4">
                    <h3 class=" text-xl font-bold">{{ $user->name }}さん</h3>
                    <p class="font-bold">お気に入り店舗</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($shops as $shop)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <img src="{{ asset($shop->image) }}" alt="{{ $shop->name }}" class="w-full h-48 object-cover" />
                            <div class="p-4">
                                <p class="text-lg font-semibold">{{ $shop->name }}</p>
                                <p class="text-sm text-gray-600">#{{ $shop->category->content }} #{{ $shop->area->name }}</p>
                                <div class="mt-4 flex justify-between items-center">
                                    <a href="/detail/{{ $shop->id }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">詳しく見る</a>
                                    <div class="item__form">
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
                </div>
            </div>
        </div>
        @section('script')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const closeButtons = document.querySelectorAll(".close-btn");

                closeButtons.forEach(button => {
                    button.addEventListener("click", function() {
                        const form = this.closest(".reservation-box");
                        if (form) {
                            form.style.visibility = "hidden";
                        }
                    });
                });
            });
        </script>
        @endsection
    </div>
</x-app-layout>