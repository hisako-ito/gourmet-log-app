<nav class="bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 md:px-4 lg:px-0 pt-4">
        <div class="w-full flex flex-col items-start md:flex-row md:justify-between gap-4">
            <div class="flex flex-row flex-wrap items-center gap-2 w-full md:w-auto">
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="bg-blue-600 text-white focus:outline-none rounded-md shadow-md w-12 p-4">
                        <i x-show="!open" class="fa-solid fa-bars"></i>
                        <i x-show="open" class="fa-solid fa-xmark"></i>
                    </button>

                    <div x-show="open" @click.away="open = false"
                        x-transition.opacity
                        class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50">
                        <div class="bg-white w-3/4 md:w-1/3 rounded-lg shadow-lg text-center py-6 relative">
                            <div class="absolute top-2 right-2 rounded-md bg-blue-600">
                                <a href="#" @click="open = false" class="close-btn text-white text-xl font-bold p-2 ">×</a>
                            </div>
                            @php
                            $isLoggedIn = Auth::guard('web')->check() || Auth::guard('owner')->check() || Auth::guard('admin')->check();
                            @endphp

                            @if ($isLoggedIn)
                            <a href="{{ route('home') }}" class="block px-4 py-2 text-blue-600 hover:bg-gray-100">Home</a>
                            @endif
                            @if (Auth::guard('web')->check())
                            <a href="{{ route('mypage') }}" class="block px-4 py-2 text-blue-600 hover:bg-gray-100">Mypage</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 text-blue-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                            @elseif (Auth::guard('owner')->check())
                            <a href="{{ route('owner.page') }}" class="block px-4 py-2 text-blue-600 hover:bg-gray-100">Mypage</a>
                            <form method="POST" action="{{ route('owner.logout') }}">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 text-blue-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                            @elseif (Auth::guard('admin')->check())
                            <a href="{{ route('admin.page') }}" class="block px-4 py-2 text-blue-600 hover:bg-gray-100">Mypage</a>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 text-blue-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                            @else
                            <a href="{{ route('register') }}" class="block px-4 py-2 text-blue-600 hover:bg-gray-100">Register</a>
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-blue-600 hover:bg-gray-100">Login</a>
                            @endif
                        </div>
                    </div>
                </div>
                @php
                $isLoggedIn = Auth::guard('web')->check() || Auth::guard('owner')->check() || Auth::guard('admin')->check();
                @endphp

                @if ($isLoggedIn && Route::has('home'))
                <div class="flex-shrink-0 flex items-center ml-2">
                    <a href="{{ route('home') }}" class="text-blue-600 text-xl font-bold">
                        Rese
                    </a>
                </div>
                @endif
            </div>
            @if ($isLoggedIn && Route::is('home','search'))
            <div class="w-full md:w-auto md:ml-auto">
                <form class="flex flex-wrap items-center bg-white px-4 py-2 rounded shadow-md gap-4 w-full max-w-full lg:max-w-[500px]" action="/search" method="get">
                    @csrf
                    <div class="relative sm:w-auto h-10">
                        <select name="area_id" class="appearance-none h-full bg-white border border-gray-300 rounded px-3 py-2 text-sm pr-6 w-full">
                            <option value="">All area</option>
                            @foreach ($areas as $area)
                            <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute right-2 inset-y-0 flex items-center text-gray-500">
                            ▼
                        </span>
                    </div>
                    <div class="relative sm:w-auto h-10">
                        <select name="category_id" class="appearance-none h-full bg-white border border-gray-300 rounded px-3 py-2 text-sm pr-6 w-full">
                            <option value="">All genre</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->content }}</option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute right-2 inset-y-0 flex items-center text-gray-500">▼</span>
                    </div>
                    <div class="relative flex-1 h-10">
                        <div class="absolute left-2 inset-y-0 flex items-center text-gray-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <input class="pl-8 border border-gray-300 rounded px-3 py-2 text-sm w-full" type="text" name="keyword" placeholder="Search..." value="{{request('keyword')}}">
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</nav>