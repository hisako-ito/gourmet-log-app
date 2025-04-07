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
                    <h2 class="text-xl font-bold">{{ $shop->name }}様の予約状況</h2>
                    @forelse ($reservations as $index => $reservation)
                    <table class="bg-blue-600 text-white rounded-lg shadow-md">
                        <tr class="px-4 pt-4 flex justify-between">
                            <td class="flex items-center"><i class="fa-regular fa-clock text-xl"></i>
                                <span class="ml-2">
                                    {{ $index === 0 ? '予約1' : '予約' . ($index + 1) }}</span>
                            </td>
                        </tr>
                        <tr class="px-4 flex items-center">
                            <th class="w-24 text-sm h-10 flex items-center">Date</th>
                            <td class="rounded w-full">{{ $reservation->date }}</td>
                        </tr>
                        <tr class="px-4 flex items-center">
                            <th class="w-24 text-sm h-10 flex items-center">Time</th>
                            <td class="rounded w-full">{{ $reservation->time }}</td>
                        </tr>
                        <tr class="px-4 pb-4 flex items-center">
                            <th class="w-24 text-sm h-10 flex items-center">Number</th>
                            <td class="w-16 px-2 text-sm rounded">{{ $reservation->number }}人</td>
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
                            <div class="form__error">
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
                                <span class="hidden absolute top-2 left-2" id="close-btn">×</span>
                                <img class="hidden w-full" src="#" alt="店舗画像" id="previewImage">
                            </div>
                            <div class="flex items-center justify-center border border-dotted border-blue-600 py-4">
                                <label for="image-input" class="inline-block px-4 py-2 bg-blue-600 text-white rounded cursor-pointer hover:bg-blue-700">画像を選択する</label>
                                <input class="hidden" type="file" name="image" id="image-input" accept="image/*">
                            </div>
                            <div class="form__error">
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
                                <select class="w-full" id="exhibition-form__select" name="category">
                                    <option class="text-center" value="" disabled selected>-- カテゴリーを選択 --</option>
                                    <option value="1" {{
                old('category') == 1 ? 'selected' : '' }}>寿司</option>
                                    <option value="2" {{
                old('category') == 2 ? 'selected' : '' }}>焼肉</option>
                                    <option value="3" {{
                old('category') == 3 ? 'selected' : '' }}>居酒屋</option>
                                    <option value="4" {{
                old('category') == 4 ? 'selected' : '' }}>イタリアン</option>
                                    <option value="5" {{
                old('category') == 4 ? 'selected' : '' }}>ラーメン</option>
                                </select>
                            </div>
                            <div class="form__error">
                                @error('category')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="">
                            <div class="">
                                <label class="font-bold">エリア</label>
                            </div>
                            <div class="">
                                <select class="w-full" id="exhibition-form__select" name="area">
                                    <option class="text-center" value="" disabled selected>-- エリアを選択 --</option>
                                    <option value="1" {{
                old('category') == 1 ? 'selected' : '' }}>北海道</option>
                                    <option value="2" {{
                old('category') == 2 ? 'selected' : '' }}>青森県</option>
                                    <option value="3" {{
                old('category') == 3 ? 'selected' : '' }}>岩手県</option>
                                    <option value="4" {{
                old('category') == 4 ? 'selected' : '' }}>宮城県</option>
                                    <option value="5" {{
                old('category') == 5 ? 'selected' : '' }}>秋田県</option>
                                    <option value="6" {{
                old('category') == 6 ? 'selected' : '' }}>山形県</option>
                                    <option value="7" {{
                old('category') == 7 ? 'selected' : '' }}>福島県</option>
                                    <option value="8" {{
                old('category') == 8 ? 'selected' : '' }}>茨城県</option>
                                    <option value="9" {{
                old('category') == 9 ? 'selected' : '' }}>栃木県</option>
                                    <option value="10" {{
                old('category') == 10 ? 'selected' : '' }}>群馬県</option>
                                    <option value="11" {{
                old('category') == 11 ? 'selected' : '' }}>埼玉県</option>
                                    <option value="12" {{
                old('category') == 12 ? 'selected' : '' }}>千葉県</option>
                                    <option value="13" {{
                old('category') == 13 ? 'selected' : '' }}>東京都</option>
                                    <option value="14" {{
                old('category') == 14 ? 'selected' : '' }}>神奈川県</option>
                                    <option value="15" {{
                old('category') == 15 ? 'selected' : '' }}>新潟県</option>
                                    <option value="16" {{
                old('category') == 16 ? 'selected' : '' }}>富山県</option>
                                    <option value="17" {{
                old('category') == 17 ? 'selected' : '' }}>石川県</option>
                                    <option value="18" {{
                old('category') == 18 ? 'selected' : '' }}>福井県</option>
                                    <option value="19" {{
                old('category') == 19 ? 'selected' : '' }}>山梨県</option>
                                    <option value="20" {{
                old('category') == 20 ? 'selected' : '' }}>長野県</option>
                                    <option value="21" {{
                old('category') == 21 ? 'selected' : '' }}>岐阜県</option>
                                    <option value="22" {{
                old('category') == 22 ? 'selected' : '' }}>静岡県</option>
                                    <option value="23" {{
                old('category') == 23 ? 'selected' : '' }}>愛知県</option>
                                    <option value="24" {{
                old('category') == 24 ? 'selected' : '' }}>三重県</option>
                                    <option value="25" {{
                old('category') == 25 ? 'selected' : '' }}>滋賀県</option>
                                    <option value="26" {{
                old('category') == 26 ? 'selected' : '' }}>京都府</option>
                                    <option value="27" {{
                old('category') == 27 ? 'selected' : '' }}>大阪府</option>
                                    <option value="28" {{
                old('category') == 28 ? 'selected' : '' }}>兵庫県</option>
                                    <option value="29" {{
                old('category') == 29 ? 'selected' : '' }}>奈良県</option>
                                    <option value="30" {{
                old('category') == 30 ? 'selected' : '' }}>和歌山県</option>
                                    <option value="31" {{
                old('category') == 31 ? 'selected' : '' }}>鳥取県</option>
                                    <option value="32" {{
                old('category') == 32 ? 'selected' : '' }}>島根県</option>
                                    <option value="33" {{
                old('category') == 33 ? 'selected' : '' }}>岡山県</option>
                                    <option value="34" {{
                old('category') == 34 ? 'selected' : '' }}>広島県</option>
                                    <option value="35" {{
                old('category') == 35 ? 'selected' : '' }}>山口県</option>
                                    <option value="36" {{
                old('category') == 36 ? 'selected' : '' }}>徳島県</option>
                                    <option value="37" {{
                old('category') == 37 ? 'selected' : '' }}>香川県</option>
                                    <option value="38" {{
                old('category') == 38 ? 'selected' : '' }}>愛媛県</option>
                                    <option value="39" {{
                old('category') == 39 ? 'selected' : '' }}>高知県</option>
                                    <option value="40" {{
                old('category') == 40 ? 'selected' : '' }}>福岡県</option>
                                    <option value="41" {{
                old('category') == 41 ? 'selected' : '' }}>佐賀県</option>
                                    <option value="42" {{
                old('category') == 42 ? 'selected' : '' }}>長崎県</option>
                                    <option value="43" {{
                old('category') == 43 ? 'selected' : '' }}>熊本県</option>
                                    <option value="44" {{
                old('category') == 44 ? 'selected' : '' }}>大分県</option>
                                    <option value="45" {{
                old('category') == 45 ? 'selected' : '' }}>宮崎県</option>
                                    <option value="46" {{
                old('category') == 46 ? 'selected' : '' }}>鹿児島県</option>
                                    <option value="47" {{
                old('category') == 47 ? 'selected' : '' }}>沖縄県</option>
                                </select>
                            </div>
                            <div class="form__error">
                                @error('category')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="">
                            <div class="">
                                <div class="">
                                    <label class="font-bold">店舗詳細</label>
                                </div>
                                <div class="">
                                    <textarea class="w-full" type="text" name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="form__error">
                                @error('description')
                                {{ $message }}
                                @enderror
                            </div>
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
            @endsection
        </div>
</x-app-layout>