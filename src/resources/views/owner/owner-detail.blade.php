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
            @if($shop->owner_id == $owner->id)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
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
                        <div class="flex flex-col gap-2 p-2 mt-2">
                            <p class="">{{ $review->user->name }}様<span class="text-xs ml-2">{{ \Carbon\Carbon::parse($review->reservation->date)->format('Y/m') }}訪問</span></p>
                            <div class="flex text-yellow-400 min-h-[24px]">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <=$review->rating)
                                    <i class="fas fa-star"></i>
                                    @else
                                    <i class="far fa-star text-gray-300"></i>
                                    @endif
                                    @endfor
                            </div>
                            <div class="bg-white w-full rounded p-2 min-h-[24px] text-sm">
                                {{ $review->comment ? $review->comment : 'コメントはありません' }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="w-full max-w-xl px-8">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-xl font-bold text-center">店舗情報更新</h3>
                    </div>
                    <pre>{{ var_export($errors->keys(), true) }}</pre>
                    <form action="{{ route('shop.update', ['shop_id' => $shop->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        @if ($errors->has('new_courses'))
                        <div class="text-red-500 text-sm mb-2">
                            {{ $errors->first('new_courses') }}
                        </div>
                        @endif
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
                        <div class="mt-2 w-full">
                            <label class="font-bold">店舗画像</label>
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
                        <div class="mt-4">
                            <label class="font-bold block mb-2">コース</label>
                            <div id="course-edit-container" data-initial-index="{{ old('new_courses') ? count(old('new_courses')) : 0 }}">
                                @foreach($courses as $index => $course)
                                <div class="course-group mb-4 border-t pt-4">
                                    <input type="hidden" name="courses[{{ $index }}][id]" value="{{ $course->id }}">
                                    @error("courses.$index.id")
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @enderror
                                    <label class="block font-semibold">コース名</label>
                                    <input type="text" name="courses[{{ $index }}][name]" class="w-full" value="{{ $course->name }}">
                                    @error("courses.$index.name")
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @enderror
                                    <label class="block font-semibold mt-2">料金</label>
                                    <select name="courses[{{ $index }}][price]" class="w-full">
                                        <option value="" class="text-center" disabled selected>-- 金額を選択 --</option>
                                        @for ($i = 1000; $i <= 10000; $i +=500)
                                            <option value="{{ $i }}"
                                            {{ old('courses.' . $index . '.price', $course->price) == $i ? 'selected' : '' }}>
                                            ¥{{ number_format($i) }}
                                            </option>
                                            @endfor
                                    </select>
                                    @error("courses.$index.price")
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @enderror
                                    <label class="block font-semibold mt-2">コース詳細</label>
                                    <input type="text" name="courses[{{ $index }}][description]" class="w-full" value="{{ $course->description }}">
                                    @error("courses.$index.description")
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @enderror

                                    <label class="inline-flex items-center mt-2">
                                        <input type="checkbox" name="courses[{{ $index }}][delete]" value="1" class="mr-2">
                                        このコースを削除する
                                    </label>
                                </div>
                                @endforeach
                                @php
                                $oldNewCourses = old('new_courses', []);
                                $errorIndexes = collect(array_keys($errors->getMessages()))
                                ->map(function ($key) {
                                if (preg_match('/new_courses\.(\d+)\./', $key, $matches)) {
                                return (int) $matches[1];
                                }
                                return null;
                                })
                                ->filter()
                                ->unique()
                                ->values();

                                $allIndexes = collect(array_keys($oldNewCourses))
                                ->map(fn($i) => (int) $i)
                                ->merge($errorIndexes)
                                ->unique()
                                ->sort()
                                ->values();
                                @endphp

                                @foreach($allIndexes as $index)
                                @include('components.new-course-input', [
                                'index' => $index,
                                'course' => $oldNewCourses[$index] ?? [],
                                ] + ['errors' => $errors]) {{-- ← errorsを明示的に渡す --}}
                                @endforeach
                            </div>
                            <button type="button" id="add-new-course" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">
                                ＋ 新しいコースを追加
                            </button>
                        </div>

                        <div class="flex justify-center gap-6">
                            <button class="px-4 py-2 bg-blue-600 text-white rounded cursor-pointer hover:bg-blue-700" type="submit">更新する</button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="w-full flex justify-center">
                <div class="flex flex-col gap-4 w-full max-w-xl px-8">
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
                        <div class="flex flex-col gap-2 p-2 mt-2">
                            <p class="">{{ $review->user->name }}様<span class="text-xs ml-2">{{ \Carbon\Carbon::parse($review->reservation->date)->format('Y/m') }}訪問</span></p>
                            <div class="flex text-yellow-400 min-h-[24px]">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <=$review->rating)
                                    <i class="fas fa-star"></i>
                                    @else
                                    <i class="far fa-star text-gray-300"></i>
                                    @endif
                                    @endfor
                            </div>
                            <div class="bg-white w-full rounded p-2 min-h-[24px] text-sm">
                                {{ $review->comment ? $review->comment : 'コメントはありません' }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    @section('script')
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addButton = document.getElementById('add-new-course');
            const container = document.getElementById('course-edit-container');
            let newCourseIndex = parseInt(container.dataset.initialIndex || 0);

            addButton.addEventListener('click', function() {
                let priceOptions = '<option value="">-- 金額を選択 --</option>';
                for (let i = 1000; i <= 10000; i += 500) {
                    priceOptions += `<option value="${i}">¥${i.toLocaleString()}</option>`;
                }

                const courseHTML = `
                <div class="mt-4 border-t pt-4">
                    <label class="block font-semibold">コース名</label>
                    <input type="text" name="new_courses[${newCourseIndex}][name]" class="w-full" value="">

                    <label class="block font-semibold mt-2">料金</label>
                    <select name="new_courses[${newCourseIndex}][price]" class="w-full">
                        ${priceOptions}
                    </select>

                    <label class="block font-semibold mt-2">コース詳細</label>
                    <input type="text" name="new_courses[${newCourseIndex}][description]" class="w-full" value="">
                </div>
            `;

                container.insertAdjacentHTML('beforeend', courseHTML);
                newCourseIndex++;
            });
        });
    </script>
    @endsection
</x-app-layout>