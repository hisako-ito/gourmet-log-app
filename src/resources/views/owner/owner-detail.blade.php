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
                    <form action="{{ route('owner.detail', ['shop_id' => $shop->id]) }}" method="post" class="" enctype="multipart/form-data">
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
                        <div class="flex justify-center gap-6">
                            <button class="px-4 py-2 bg-blue-600 text-white rounded cursor-pointer hover:bg-blue-700" type="submit">更新する</button>
                        </div>
                    </form>
                </div>
            </div>
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
    @endsection
</x-app-layout>