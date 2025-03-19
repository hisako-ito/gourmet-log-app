<x-app-layout>
    @section('title','予約詳細')
    <div class="py-4 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="text-xl font-bold inline-block"><button class="bg-white mb-4 shadow-md">
                            </button></a><span class="font-bold inline-block">{{ $shop->name }}</span>
                    </div>
                    <img src="{{ asset($shop->image) }}" alt="店舗画像" class="w-full h-[300px] object-cover rounded shadow-md mb-4" />
                    <p class="text-gray-700 mb-2">#{{ $shop->area->name }} #{{ $shop->category->content }}</p>
                    <p class="text-gray-800 leading-relaxed">{{ $shop->description }}</p>
                </div>
                <div class="bg-blue-600 text-white rounded-lg shadow-lg p-6 flex flex-col justify-between">
                    <div class="">
                        <h3 class="text-xl font-bold mb-4">予約</h3>
                        <form action="/detail/{{ $shop->id }}" method="post" class="flex flex-col space-y-4">
                            @csrf
                            <input type="hidden" name="id" value="{{ $shop->id }}" />
                            <div>
                                <input type="date" name="date" style="color: black;" class="p-2 rounded block"
                                    value="{{ old('date', request('date')) }}">
                                <p class="">
                                    @error('date')
                                    {{ $message }}
                                    @enderror
                                </p>
                            </div>
                            <div>
                                <select name="time" class="w-full p-2 text-black rounded block" value="{{request('time')}}">
                                    <option value=""></option>
                                    @for ($i = 0; $i <= 24; $i++)
                                        <option value="{{ $i }}:00">{{ $i }}:00</option>
                                        @endfor
                                </select>
                                <p class="">
                                    @error('time')
                                    {{ $message }}
                                    @enderror
                                </p>
                            </div>
                            <div>
                                <select name="number" class="w-full p-2 text-black rounded block" value="{{request('number')}}">
                                    <option value=""></option>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}人</option>
                                        @endfor
                                </select>
                                <p class="">
                                    @error('number')
                                    {{ $message }}
                                    @enderror
                                </p>
                            </div>

                            <div class="bg-blue-500 p-4 rounded text-sm text-white">
                                <p><strong>Shop</strong>: {{ $shop->name }}</p>
                                <p><strong>Date</strong>: <span id="selected-date">未選択</span></p>
                                <p><strong>Time</strong>: <span id="selected-time">未選択</span></p>
                                <p><strong>Number</strong>: <span id="selected-number">未選択</span></p>
                            </div>
                            <button type="submit" class="mt-4 w-full bg-blue-800 hover:bg-blue-900 py-2 rounded">予約する</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('script')
    <script>
        const dateInput = document.querySelector('input[name="date"]');
        const timeSelect = document.querySelector('select[name="time"]');
        const numberSelect = document.querySelector('select[name="number"]');

        const dateSpan = document.getElementById('selected-date');
        const timeSpan = document.getElementById('selected-time');
        const numberSpan = document.getElementById('selected-number');

        dateInput.addEventListener('input', () => dateSpan.textContent = dateInput.value);
        timeSelect.addEventListener('input', () => timeSpan.textContent = timeSelect.value + ':00');
        numberSelect.addEventListener('input', () => numberSpan.textContent = numberSelect.value + '人');
    </script>
    @endsection
</x-app-layout>