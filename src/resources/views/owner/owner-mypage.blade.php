<x-app-layout>
    @section('title','店舗責任者ページ')
    <div class="p-4">
        <div class="max-w-7xl mx-auto">
            <div class="">
                @if (session('message'))
                <div class="bg-white text-black p-4 text-xl font-bold mb-4">
                    {{ session('message') }}
                </div>
                @endif
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-6">
                    <h2 class="text-xl font-bold">{{ $owner->name }}様の店舗の予約状況</h2>
                    <form id="shopSelectForm">
                        <label for="shopSelect">店舗を選択:</label>
                        <select id="shopSelect" name="shop_id">
                            <option class="text-center" value="" disabled>-- 店舗を選択 --</option>
                            @foreach($shops as $shop)
                            <option value="{{ $shop->id }}" {{ (isset($shop_id) && $shop_id == $shop->id) ? 'selected' : '' }}>
                                {{ $shop->name }}
                            </option>
                            @endforeach
                        </select>
                    </form>
                    @forelse ($reservations as $index => $reservation)
                    <table class="table-fixed bg-blue-600 text-white rounded-lg w-full">
                        <tr class="">
                            <td class="px-4 py-2"><i class="fa-regular fa-clock text-xl"></i>
                                <span class="">
                                    {{ $index === 0 ? '予約1' : '予約' . ($index + 1) }}</span>
                            </td>
                        </tr>
                        <tr class="">
                            <th class="w-24 px-4 py-2 text-center whitespace-nowrap">Date</th>
                            <td class="px-4 py-2">{{ $reservation->date }}</td>
                        </tr>
                        <tr class="">
                            <th class="w-24 px-4 py-2 text-center whitespace-nowrap">Time</th>
                            <td class="px-4 py-2">{{ $reservation->time }}</td>
                        </tr>
                        <tr class="">
                            <th class="w-24 px-4 py-2 text-center whitespace-nowrap">Course</th>
                            <td class="px-4 py-2">{{ $reservation->course->name }}:{{ $reservation->course->price }}円</td>
                        </tr>
                        <tr class="">
                            <th class="w-24 px-4 py-2 text-center whitespace-nowrap">Number</th>
                            <td class="px-4 py-2">{{ $reservation->number }}人</td>
                        </tr>
                    </table>
                    @empty
                    <div class="bg-blue-600 text-white rounded-lg shadow-md p-6 min-h-[200px] flex items-center justify-center">
                        現在、予約はありません。
                    </div>
                    @endforelse
                </div>

                <div class="p-4">
                    <div class="flex flex-col gap-4">
                        <h3 class="text-xl font-bold text-center">店舗登録</h3>
                    </div>
                    <form class="flex flex-col gap-4 px-4" action="/owner/mypage" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="">
                            <div class="">
                                <label class="font-bold" for="name">店舗名</label>
                            </div>
                            <div class="">
                                <div class="">
                                    <input type="text" class="w-full" name="name" id="name" value="{{ old('name') }}">
                                </div>
                            </div>
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
                                <input class="hidden" type="file" name="image" id="image-input" accept="image/*">
                            </div>
                            <div class="text-red-500">
                                @error('image')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="">
                            <div class="">
                                <label class="font-bold">カテゴリー</label>
                            </div>
                            <div class="">
                                <select class="w-full" name="category_id">
                                    <option class="text-center" value="" disabled selected>-- カテゴリーを選択 --</option>
                                    @foreach($categories as $category)
                                    <option class="" value="{{ $category->id }}" {{
                old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->content }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-red-500">
                                @error('category_id')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="">
                            <div class="">
                                <label class="font-bold">エリア</label>
                            </div>
                            <div class="">
                                <select class="w-full" name="area_id">
                                    <option class="text-center" value="" disabled selected>-- エリアを選択 --</option>
                                    @foreach($areas as $area)
                                    <option class="" value="{{ $area->id }}" {{
                old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-red-500">
                                @error('area_id')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="">
                            <div class="">
                                <label class="font-bold">店舗詳細</label>
                            </div>
                            <div class="">
                                <textarea class="w-full rounded" type="text" name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                            </div>
                            <div class="text-red-500">
                                @error('description')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="font-bold block mb-2">コース一覧</label>
                            <div id="course-container" data-course-index="{{ count(old('courses', [['name' => '', 'price' => '', 'description' => '']])) }}">
                                @php
                                $oldCourses = old('courses', [['name' => '', 'price' => '', 'description' => '']]);
                                @endphp

                                @foreach ($oldCourses as $index => $course)
                                @include('components.course-input', ['index' => $index])
                                @endforeach
                            </div>
                            <button type="button" id="add-course" class="mt-2 bg-gray-300 px-3 py-1 rounded hover:bg-gray-400">＋コースを追加</button>
                        </div>
                        <input type="hidden" name="owner_id" value="{{ $owner->id }}">
                        <div class="text-center">
                            <button class="px-4 py-2 bg-blue-600 text-white rounded cursor-pointer hover:bg-blue-700" type="submit">登録する</button>
                        </div>
                    </form>
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
                document.getElementById('shopSelect').addEventListener('change', function() {
                    const shopId = this.value;
                    window.location.href = `/owner/mypage/${shopId}`;
                });
            </script>
            <script>
                let courseIndex = parseInt(document.getElementById('course-container').dataset.courseIndex || 0);
                document.getElementById('add-course').addEventListener('click', function() {
                    const container = document.getElementById('course-container');
                    let priceOptions = '';
                    for (let i = 1000; i <= 10000; i += 500) {
                        priceOptions += `<option value="${i}">¥${i.toLocaleString()}</option>`;
                    }

                    container.insertAdjacentHTML('beforeend', `
                        <div class="course-group mt-4">
                            <label class="font-bold">コース名</label>
                            <input type="text" name="courses[${courseIndex}][name]" class="w-full" placeholder="コース名">

                            <label class="font-bold mt-2">料金</label>
                            <select name="courses[${courseIndex}][price]" class="w-full">
                                <option value="" class="text-center">-- 金額を選択 --</option>
                                ${priceOptions}
                            </select>

                            <label class="font-bold mt-2">コース詳細</label>
                            <input type="text" name="courses[${courseIndex}][description]" class="w-full" placeholder="コース詳細">
                        </div>
                    `);
                    courseIndex++;
                });
            </script>
            @endsection
        </div>
</x-app-layout>