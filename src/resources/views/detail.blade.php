<x-app-layout>
    @section('title','店舗詳細')
    <div class="py-4 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="">
                @if (session('message'))
                <div class="bg-white text-black p-4 text-xl font-bold mb-4">
                    {{ session('message') }}
                </div>
                @endif
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="mr-2">
                            <button class="bg-white text-xl px-3 py-1 rounded shadow-md"><i class="fa-solid fa-chevron-left"></i></button></a>
                        <h2 class="inline text-xl font-bold">{{ $shop->name }}</h2>
                    </div>
                    <img src="{{ asset('storage/' . $shop->image) }}" alt="店舗画像" class="w-full h-[300px] object-cover rounded shadow-md" />
                    <div>
                        <p class="">#{{ $shop->area->name }}&nbsp#{{ $shop->category->content }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">店舗詳細</h3>
                        <p class="ml-4 leading-relaxed">{{ $shop->description }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">コース一覧</h3>
                        <ul class="ml-4">
                            @foreach($courses as $course)
                            <li>{{ $course->name }}：{{ $course->price }}円 {{ $course->description }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="">
                        <h3 class="text-lg font-bold">評価</h3>
                        @foreach ($shop->reviews as $review)
                        <div class="flex flex-col gap-2 p-2">
                            <p class="">{{ $review->user->name }}様<span class="text-xs ml-2">{{ \Carbon\Carbon::parse($review->reservation->date)->format('Y/m') }}訪問</span></p>
                            <div class="flex text-yellow-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <=$review->rating)
                                    <i class="fas fa-star"></i>
                                    @else
                                    <i class="far fa-star"></i>
                                    @endif
                                    @endfor
                            </div>
                            <div class="bg-white w-full rounded p-2" readonly>{{ $review->comment }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="bg-blue-600 text-white rounded-lg shadow-lg p-6 flex flex-col justify-between">
                    <div class="">
                        <h3 class="text-xl font-bold mb-4">予約</h3>
                        <form action="/detail/{{ $shop->id }}" method="post" class="flex flex-col gap-2">
                            @csrf
                            <input type="hidden" name="id" value="{{ $shop->id }}" />
                            <div>
                                <input type="date" name="date" style="color: black;" class="p-2 rounded block"
                                    value="{{ old('date', request('date')) }}">
                            </div>
                            <div>
                                @error('date')
                                {{ $message }}
                                @enderror
                            </div>
                            <div class="relative">
                                <select name="time" class="w-full p-2 text-black rounded block">
                                    <option value="" disabled selected>-- 時間を選択 --</option>
                                    @for ($i = 11; $i <= 21; $i++)
                                        <option value="{{ $i }}:00" {{ old('time') == $i . ':00' ? 'selected' : '' }}>{{ $i }}:00</option>
                                        @endfor
                                </select>
                                <span class="pointer-events-none absolute right-2 inset-y-0 flex items-center text-gray-500">▼</span>
                            </div>
                            <div>
                                @error('time')
                                {{ $message }}
                                @enderror
                            </div>
                            <div class="relative">
                                <select name="course_id" class="w-full p-2 text-black rounded block">
                                    <option value="" disabled selected>-- コースを選択 --</option>
                                    @foreach($courses as $course)
                                    <option class="" value="{{ $course->id }}" data-price="{{ $course->price }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}：{{ $course->price }}円</option>
                                    @endforeach
                                </select>
                                <span class="pointer-events-none absolute right-2 inset-y-0 flex items-center text-gray-500">▼</span>
                            </div>
                            <div>
                                @error('course_id')
                                {{ $message }}
                                @enderror
                            </div>
                            <div class="relative">
                                <select name="number" class="w-full p-2 text-black rounded block">
                                    <option value="" disabled selected>-- 人数を選択 --</option>
                                    @for ($i = 1; $i <= 20; $i++)
                                        <option value="{{ $i }}" {{ old('number') == $i ? 'selected' : '' }}>{{ $i }}人</option>
                                        @endfor
                                </select>
                                <span class="pointer-events-none absolute right-2 inset-y-0 flex items-center text-gray-500">▼</span>
                            </div>
                            <div>
                                @error('number')
                                {{ $message }}
                                @enderror
                            </div>

                            <div class="bg-blue-500 p-8 rounded text-sm text-white">
                                <p class=""><strong>Shop</strong>: {{ $shop->name }}</p>
                                <p class="mt-2"><strong>Date</strong>: <span id="selected-date">未選択</span></p>
                                <p class="mt-2"><strong>Time</strong>: <span id="selected-time">未選択</span></p>
                                <p class="mt-2"><strong>Course</strong>: <span id="selected-course">未選択</span></p>
                                <p class="mt-2"><strong>Number</strong>: <span id="selected-number">未選択</span></p>
                                <p class="mt-2"><strong>Total price</strong>: <span id="total-price">円</span></p>
                            </div>
                            <button type="submit" class="mt-4 w-full bg-blue-600 hover:bg-blue-900 py-2 rounded">予約する</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dateInput = document.querySelector('input[name="date"]');
            const timeSelect = document.querySelector('select[name="time"]');
            const courseSelect = document.querySelector('select[name="course_id"]');
            const numberSelect = document.querySelector('select[name="number"]');

            const selectedDate = document.getElementById('selected-date');
            const selectedCourse = document.getElementById('selected-course');
            const selectedTime = document.getElementById('selected-time');
            const selectedNumber = document.getElementById('selected-number');

            const totalPriceDisplay = document.querySelector('span[id="total-price"]');

            function updateTotalPrice() {
                const courseOption = courseSelect.selectedOptions[0];
                const coursePrice = courseOption ? parseInt(courseOption.dataset.price || 0) : 0;
                const number = parseInt(numberSelect.value || 0);

                if (coursePrice && number) {
                    const total = coursePrice * number;
                    totalPriceDisplay.textContent = `${total.toLocaleString()}円`;
                } else {
                    totalPriceDisplay.textContent = '円';
                }
            }

            dateInput.addEventListener('change', function() {
                selectedDate.textContent = this.value || '未選択';
            });

            timeSelect.addEventListener('change', function() {
                selectedTime.textContent = this.value ? this.value : '未選択';
            });

            courseSelect.addEventListener('change', function() {
                selectedCourse.textContent = this.selectedOptions[0]?.text || '未選択';
                updateTotalPrice();
            });

            numberSelect.addEventListener('change', function() {
                selectedNumber.textContent = this.value ? this.value + '人' : '未選択';
                updateTotalPrice();
            });

            selectedDate.textContent = dateInput.value || '未選択';
            selectedTime.textContent = timeSelect.value ? timeSelect.selectedOptions[0].text : '未選択';
            selectedCourse.textContent = courseSelect.value ? courseSelect.selectedOptions[0].text : '未選択';
            selectedNumber.textContent = numberSelect.value ? numberSelect.selectedOptions[0].text : '未選択';
            updateTotalPrice();
        });
    </script>
    @endsection
</x-app-layout>