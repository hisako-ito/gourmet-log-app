<!-- resources/views/test.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>テスト</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="p-10">
    <select name="number" class="w-full p-2 bg-white text-black border border-gray-400 rounded">
        @for ($i = 1; $i <= 10; $i++)
            <option value="{{ $i }}">{{ $i }}人</option>
            @endfor
    </select>
</body>

</html>