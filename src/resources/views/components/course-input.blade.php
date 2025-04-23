<div class="course-group mb-4">
    <label class="font-bold">コース名</label>
    <input type="text" name="courses[{{ $index }}][name]" class="w-full" placeholder="例：ディナーコース"
        value="{{ old("courses.$index.name") }}">
    @error("courses.$index.name")
    <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror

    <label class="font-bold mt-2">料金</label>
    <select name="courses[{{ $index }}][price]" class="w-full">
        <option value="" class="text-center">-- 金額を選択 --</option>
        @for ($i = 1000; $i <= 10000; $i +=500)
            <option value="{{ $i }}" {{ old("courses.$index.price") == $i ? 'selected' : '' }}>
            ¥{{ number_format($i) }}
            </option>
            @endfor
    </select>
    @error("courses.$index.price")
    <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror

    <label class="font-bold mt-2">コース詳細</label>
    <input type="text" name="courses[{{ $index }}][description]" class="w-full" placeholder="例：前菜、メイン、デザートがついています"
        value="{{ old("courses.$index.description") }}">
    @error("courses.$index.description")
    <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>