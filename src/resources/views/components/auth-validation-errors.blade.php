@props(['errors'])

@if ($errors->any())
<div {{ $attributes }}>
    <div class="ml-3 font-medium text-red-600">
        入力内容にエラーがあります：
    </div>

    <ul class="ml-3 mt-3 list-disc list-inside text-sm text-red-600">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif