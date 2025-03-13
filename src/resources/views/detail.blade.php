<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <script src="{{ mix('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="{{ asset('css/output.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css')}}">
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <main>
            <div class="p-2">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-2">
                    <div class="flex">
                        <div x-data="{ open: false }">
                            <button @click="open = !open" class="bg-blue-600 text-white focus:outline-none rounded-md shadow-md w-12 p-4">
                                <i x-show="!open" class="fa-solid fa-bars"></i>
                                <i x-show="open" class="fa-solid fa-xmark"></i>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                x-transition.opacity
                                class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50">
                                <div class="bg-white w-3/4 md:w-1/3 rounded-lg shadow-lg text-center">
                                    <a href="{{ route('home') }}" class="block px-4 py-2 text-blue-600 hover:bg-gray-100">Home</a>
                                    @auth
                                    <a href="{{ route('mypage') }}" class="block px-4 py-2 text-blue-600 hover:bg-gray-100">Mypage</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full px-4 py-2 text-blue-600 hover:bg-gray-100">
                                            Logout
                                        </button>
                                    </form>
                                    @else
                                    <a href="{{ route('register') }}" class="block px-4 py-2 text-blue-600 hover:bg-gray-100">Register</a>
                                    <a href="{{ route('login') }}" class="block px-4 py-2 text-blue-600 hover:bg-gray-100">Login</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="flex-shrink-0 flex items-center ml-4">
                                <a href="{{ route('home') }}" class="text-blue-600 text-xl font-bold">
                                    Rese
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-8">
                        <div>
                            <a href="{{ route('home') }}" class="text-xl font-bold inline-block mb-4 bg-white">&lt;<span>{{ $shop->name }}</span></a>
                            <img src="{{ asset($shop->image) }}" alt="店舗画像" class="w-full h-[300px] object-cover rounded shadow-md mb-4" />
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
                                        <input type="date" name="date" class="p-2 text-black rounded block" value="{{request('date')}}" />
                                    </div>
                                    <div>
                                        <select name="time" class="w-full p-2 text-black rounded block" value="{{request('time')}}">
                                            <option value=""></option>
                                            @for ($i = 0; $i <= 24; $i++)
                                                <option value="{{ $i }}">{{ $i }}:00</option>
                                                @endfor
                                        </select>
                                    </div>
                                    <div>
                                        <select name="number" class="w-full p-2 text-black rounded block" value="{{request('number')}}">
                                            <option value=""></option>
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}">{{ $i }}人</option>
                                                @endfor
                                        </select>
                                    </div>

                                    <div class="bg-blue-500 p-4 rounded text-sm text-white">
                                        <p><strong>Shop</strong>: {{ $shop->name }}</p>
                                        <p><strong>Date</strong>: <span id="selected-date">未選択</span></p>
                                        <p><strong>Time</strong>: <span id="selected-time">未選択</span></p>
                                        <p><strong>Number</strong>: <span id="selected-number">未選択</span></p>
                                    </div>
                                    <button type="submit" class="mt-4 w-full bg-blue-800 hover:bg-blue-900 py-2 rounded">予約する</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </main>
    </div>
    <script>
        const dateInput = document.querySelector('input[name="date"]');
        const timeSelect = document.querySelector('select[name="time"]'); // ← 修正ポイント
        const numberSelect = document.querySelector('select[name="number"]');

        const dateSpan = document.getElementById('selected-date');
        const timeSpan = document.getElementById('selected-time');
        const numberSpan = document.getElementById('selected-number');

        dateInput.addEventListener('input', () => dateSpan.textContent = dateInput.value);
        timeSelect.addEventListener('input', () => timeSpan.textContent = timeSelect.value + ':00'); // ← 修正ポイント
        numberSelect.addEventListener('input', () => numberSpan.textContent = numberSelect.value + '人');
    </script>
</body>

</html>