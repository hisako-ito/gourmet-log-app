<x-app-layout>
    @section('title','予約詳細')
    <div class="py-4 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="">
                @if (session('message'))
                <div class="bg-white text-black p-4 text-xl font-bold mb-4">
                    {{ session('message') }}
                </div>
                @endif
            </div>
            @if (Auth::guard('web')->check())
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <div class="flex items-center mb-4">
                        <a href="{{ route('home') }}" class="mr-2">
                            <button class="bg-white text-xl px-3 py-1 rounded shadow-md"><i class="fa-solid fa-chevron-left"></i></button></a><span class="text-xl font-bold">{{ $shop->name }}</span>
                    </div>
                    <img src="{{ asset('storage/' . $shop->image) }}" alt="店舗画像" class="w-full h-[300px] object-cover rounded shadow-md mb-4" />
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
                            <div class="relative">
                                <select name="time" class="w-full p-2 text-black rounded block" value="{{request('time')}}">
                                    <option value=""></option>
                                    @for ($i = 0; $i <= 24; $i++)
                                        <option value="{{ $i }}:00">{{ $i }}:00</option>
                                        @endfor
                                </select>
                                <span class="pointer-events-none absolute right-2 inset-y-0 flex items-center text-gray-500">▼</span>
                                <p class="">
                                    @error('time')
                                    {{ $message }}
                                    @enderror
                                </p>
                            </div>
                            <div class="relative">
                                <select name="number" class="w-full p-2 text-black rounded block" value="{{request('number')}}">
                                    <option value=""></option>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}人</option>
                                        @endfor
                                </select>
                                <span class="pointer-events-none absolute right-2 inset-y-0 flex items-center text-gray-500">▼</span>
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
                            <button type="submit" class="mt-4 w-full bg-blue-600 hover:bg-blue-900 py-2 rounded">予約する</button>
                        </form>
                    </div>
                </div>
            </div>
            @elseif (Auth::guard('owner')->check() && $shop->owner_id == $owner->id )
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <div class="flex items-center mb-4">
                        <a href="{{ route('home') }}" class="mr-2">
                            <button class="bg-white text-xl px-3 py-1 rounded shadow-md"><i class="fa-solid fa-chevron-left"></i></button></a><span class="text-xl font-bold">{{ $shop->name }}</span>
                    </div>
                    <img src="{{ asset('storage/' . $shop->image) }}" alt="店舗画像" class="w-full h-[300px] object-cover rounded shadow-md mb-4" />
                    <p class="text-gray-700 mb-2">#{{ $shop->area->name }} #{{ $shop->category->content }}</p>
                    <p class="text-gray-800 leading-relaxed">{{ $shop->description }}</p>
                </div>
                <div class="w-full max-w-xl px-8">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-xl font-bold text-center">店舗情報更新</h3>
                    </div>
                    <form action="/detail/{{ $shop->id }}" method="post" class="" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <input type="hidden" name="id" value="{{ $shop->id }}" />
                        <div class="mt-2 w-full">
                            <label class="font-bold">店舗名</label>
                            <input type="text" name="name" class="rounded w-full" value="{{ $shop->name }}">
                            <div class="text-red-500">
                                @error('name')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="">
                            <div class="">
                                <label class="font-bold">店舗画像</label>
                            </div>
                            <div class="relative" id="imagePreview">
                                <div class="absolute top-2 left-2 rounded-full bg-white"><span class="hidden w-6 h-6 text-black cursor-pointer text-center" id="close-btn">×</span></div>
                                <img class="hidden w-full" src="#" alt="店舗画像" id="previewImage">
                            </div>
                            <div class="flex items-center justify-center border border-dotted border-blue-600 py-4">
                                <label for="image-input" class="inline-block px-4 py-2 bg-blue-600 text-white rounded cursor-pointer hover:bg-blue-700">画像を選択する</label>
                                <input class="hidden" type="file" value="{{ $shop->image }}" name="image" id="image-input" accept="image/*">
                            </div>
                            <div class="text-red-500">
                                @error('image')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mt-2 w-full">
                            <label class="font-bold">エリア</label>
                            <select class="w-full" name="area_id">
                                <option class="" value="{{ $shop->area->id }}" selected>{{ $shop->area->name }}</option>
                                @foreach($areas as $area)
                                <option class="" value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                            <div class="text-red-500">
                                @error('area_id')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mt-2 w-full">
                            <label class="font-bold">カテゴリー</label>
                            <select class="w-full" name="category_id">
                                <option class="" value="{{ $shop->category->id }}" selected>{{ $shop->category->content }}</option>
                                @foreach($categories as $category)
                                <option class="" value="{{ $category->id }}">{{ $category->content }}</option>
                                @endforeach
                            </select>
                            <div class="text-red-500">
                                @error('category_id')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mt-2 w-full">
                            <label class="font-bold">店舗詳細</label>
                            <textarea class="w-full h-[125px]" name="description">{{ $shop->description }}</textarea>
                            <div class="text-red-500">
                                @error('description')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="flex justify-center gap-6">
                            <button class="px-4 py-2 bg-blue-600 text-white rounded cursor-pointer hover:bg-blue-700" type="submit">更新する</button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="w-full flex justify-center">
                <div class="w-full max-w-xl px-8">
                    <div class="flex items-center mb-4">
                        <a href="{{ route('home') }}" class="mr-2">
                            <button class="bg-white text-xl px-3 py-1 rounded shadow-md"><i class="fa-solid fa-chevron-left"></i></button></a><span class="text-xl font-bold">{{ $shop->name }}</span>
                    </div>
                    <img src="{{ asset($shop->image) }}" alt="店舗画像" class="w-full h-[300px] object-cover rounded shadow-md mb-4" />
                    <p class="text-gray-700 mb-2">#{{ $shop->area->name }} #{{ $shop->category->content }}</p>
                    <p class="text-gray-800 leading-relaxed">{{ $shop->description }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    @section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dateInput = document.querySelector('input[name="date"]');
            const timeSelect = document.querySelector('select[name="time"]');
            const numberSelect = document.querySelector('select[name="number"]');

            const selectedDate = document.getElementById('selected-date');
            const selectedTime = document.getElementById('selected-time');
            const selectedNumber = document.getElementById('selected-number');

            dateInput.addEventListener('change', function() {
                selectedDate.textContent = this.value || '未選択';
            });

            timeSelect.addEventListener('change', function() {
                selectedTime.textContent = this.value ? this.value : '未選択';
            });

            numberSelect.addEventListener('change', function() {
                selectedNumber.textContent = this.value ? this.value + '人' : '未選択';
            });

            selectedDate.textContent = dateInput.value || '未選択';
            selectedTime.textContent = timeSelect.value || '未選択';
            selectedNumber.textContent = numberSelect.value ? numberSelect.value + '人' : '未選択';
        });
    </script>
    <script>
        const imageInput = document.getElementById("image-input");
        const previewImage = document.getElementById("previewImage");
        const imagePreview = document.getElementById("imagePreview");
        const closeBtn = document.getElementById("close-btn");

        imageInput.addEventListener("change", function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.style.display = "block";
                    previewImage.src = e.target.result;
                    previewImage.style.display = "block";
                    closeBtn.style.display = "block";
                };

                reader.readAsDataURL(file);
            }
        });

        closeBtn.addEventListener("click", function() {
            previewImage.src = "#";
            previewImage.style.display = "none";
            closeBtn.style.display = "none";
            imagePreview.style.display = "none";
            imageInput.value = "";
        });
    </script>
    @endsection
</x-app-layout>