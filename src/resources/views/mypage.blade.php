<x-app-layout>
    <div class="py-12 px-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-6">
                    @foreach ($reservations as $index => $reservation)
                    <form class="bg-blue-600 text-white rounded-lg shadow-md p-6 relative reservation-box">
                        <div class="flex justify-between">
                            <div class=""><i class="fa-regular fa-clock text-xl"></i>
                                {{ $index === 0 ? '予約1' : '予約' . ($index + 1) }}
                            </div>
                            <div class="">
                                <button type="button" class="close-btn text-white text-xl font-bold"><i class="fa-regular fa-circle-xmark"></i></button>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="text-sm w-1/3">Shop</label>
                            <input class="" value="{{ $reservation->shop->name }}"></input>
                        </div>
                        <div class="mt-2">
                            <label class="text-sm">Date</label>
                            <input class="" value="{{ $reservation->date }}"></input>
                        </div>
                        <div class="mt-2">
                            <label class="text-sm">Time</label>
                            <input class="" value="{{ $reservation->time }}"></input>
                        </div>
                        <div class="mt-2">
                            <label class="text-sm">Number</label>
                            <input class="" value="{{ $reservation->number }}人"></input>
                        </div>
                    </form>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach ($shops as $shop)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset($shop->image) }}" alt="{{ $reservation->shop->name }}" class="w-full h-48 object-cover" />
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
</x-app-layout>