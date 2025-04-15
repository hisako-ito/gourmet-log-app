<x-app-layout>
    @section('title','マイページ')
    <div class="p-4">
        <div class="max-w-7xl mx-auto">
            <div class="">
                @if (session('message'))
                <div class="bg-white text-black p-4 text-xl font-bold mb-4">
                    {{ session('message') }}
                </div>
                @endif
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="flex flex-col">
                    <h2 class="text-xl font-bold">予約状況</h2>
                    @forelse ($reservations as $index => $reservation)
                    <div class="mt-4 px-4 pt-4 bg-blue-600 text-white rounded-lg shadow-md">
                        <div class="flex justify-between">
                            <div class="flex items-center text-white"><i class="fa-regular fa-clock text-xl"></i>
                                <span class="ml-2">
                                    {{ $index === 0 ? '予約1' : '予約' . ($index + 1) }}</span>
                            </div>
                            <div>
                                <form action=" /reservation/delete/{{ $reservation->id }}" method="post" class="reservation-box">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="close-btn text-white text-xl font-bold">
                                        <i class="fa-regular fa-circle-xmark"></i>
                                    </button>
                                    <input type="hidden" name="id" value="{{ $reservation->id }}">
                                </form>
                            </div>
                        </div>
                        <form action="/reservation/update/{{ $reservation->id }}" method="post">
                            @csrf
                            @method('PATCH')
                            <table class="table-fixed bg-blue-600 text-white rounded-b-lg relative w-full">
                                <tr class="">
                                    <th class="w-24 px-4 py-2 text-left whitespace-nowrap">Shop</th>
                                    <td class="px-4 py-2">
                                        <input class="h-10 px-2 py-[5px] text-sm border border-gray-300 rounded w-full" value="{{ $reservation->shop->name }}" readonly>
                                    </td>
                                </tr>
                                <tr class="">
                                    <th class="w-24 px-4 py-2 text-left whitespace-nowrap">Date</th>
                                    <td class="px-4 py-2">
                                        <input style="color: black;" class="h-10 px-4 py-[5px] text-sm border border-gray-300 rounded w-full" type="date" name="date[{{ $reservation->id }}]" value="{{ old("date.{$reservation->id}", $reservation->date) }}">
                                        @if ($errors->getBag('edit_' . $reservation->id)->has("date.{$reservation->id}"))
                                        <p class="form__error">
                                            {{ $errors->getBag('edit_' . $reservation->id)->first("date.{$reservation->id}") }}
                                        </p>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="">
                                    <th class="w-24 px-2 py-2 text-left whitespace-nowrap">Time</th>
                                    <td class="px-4 py-2">
                                        <div class="relative">
                                            <select name="time[{{ $reservation->id }}]" class="h-10 px-3 py-[5px] text-sm border border-gray-300 rounded w-full">
                                                @php
                                                $currentTime = old("time.{$reservation->id}", \Carbon\Carbon::parse($reservation->time)->format('H:i'));
                                                @endphp
                                                @for ($i = 0; $i <= 23; $i++)
                                                    @php $timeOption=str_pad($i, 2, '0' , STR_PAD_LEFT) . ':00' ; @endphp
                                                    <option value="{{ $timeOption }}" {{ $currentTime == $timeOption ? 'selected' : '' }}>
                                                    {{ $timeOption }}
                                                    </option>
                                                    @endfor
                                            </select>
                                            <span class="pointer-events-none absolute right-2 inset-y-0 flex items-center text-gray-500">▼</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="">
                                    <th class="w-24 px-2 py-2 text-left whitespace-nowrap">Number</th>
                                    <td class="px-4 py-2">
                                        <div class="relative">
                                            <select name="number[{{ $reservation->id }}]" class="h-10 px-3 py-[5px] text-sm border border-gray-300 rounded w-full">
                                                @for ($i = 1; $i <= 20; $i++)
                                                    <option value="{{ $i }}" {{ old("number.{$reservation->id}", $reservation->number) == $i ? 'selected' : '' }}>
                                                    {{ $i }}人
                                                    </option>
                                                    @endfor
                                            </select>
                                            <span class="pointer-events-none absolute right-2 inset-y-0 flex items-center text-gray-500">▼</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div class="px-4 py-2 text-center">
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
                    <h3 class="text-xl font-bold">{{ $user->name }}さん</h3>
                    <h4 class="text-lg font-bold">お気に入り店舗</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($shops as $shop)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <img src="{{ asset('storage/' . $shop->image) }}" alt="{{ $shop->name }}" class="w-full h-48 object-cover" />
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