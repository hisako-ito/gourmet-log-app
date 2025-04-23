<div class="course-group mb-4 border-t pt-4">
    <label class="block font-semibold">コース名</label>
    <input type="text" name="new_courses[{{ $index }}][name]" class="w-full"
        value="{{ old("new_courses.$index.name", $course['name'] ?? '') }}">
    @error("new_courses.$index.name")
    <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror

    <label class="block font-semibold mt-2">料金</label>
    <select name="new_courses[{{ $index }}][price]" class="w-full">
        <option value="">-- 金額を選択 --</option>
        @for ($i = 1000; $i <= 10000; $i +=500)
            <option value="{{ $i }}" {{ old("new_courses.$index.price", $course['price'] ?? '') == $i ? 'selected' : '' }}>
            ¥{{ number_format($i) }}
            </option>
            @endfor
    </select>
    @error("new_courses.$index.price")
    <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror

    <label class="block font-semibold mt-2">コース詳細</label>
    <input type="text" name="new_courses[{{ $index }}][description]" class="w-full"
        value="{{ old("new_courses.$index.description", $course['description'] ?? '') }}">
    @error("new_courses.$index.description")
    <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>