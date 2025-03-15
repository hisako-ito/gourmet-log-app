<nav class="bg-gray-100">
    <div class="max-w-7xl mx-auto px-6 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between py-2">
            <div class="flex">
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="bg-blue-600 text-white focus:outline-none rounded-md shadow-md w-12 p-4">
                        <i x-show="!open" class="fa-solid fa-bars"></i>
                        <i x-show="open" class="fa-solid fa-xmark"></i>
                    </button>

                    <div x-show="open" @click.away="open = false"
                        x-transition.opacity
                        class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50">
                        <div class="bg-white w-3/4 md:w-1/3 rounded-lg shadow-lg text-center py-6 relative">
                            <div class="absolute top-2 left-2">
                                <a href="#" @click="open = false" class="close-btn bg-blue-600 text-white text-xl font-bold p-2">×</a>
                            </div>
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
            @if (Auth::check() && Route::is('home','search'))
            <div class="flex">
                <form class="" action="/search" method="get">
                    @csrf
                    <select name="area_id" class="border border-gray-300 rounded px-2 py-1 text-sm">
                        <option value="">All area</option>
                        @foreach ($areas as $area)
                        <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                        @endforeach
                    </select>
                    <select name="category_id" class="border border-gray-300 rounded px-4 py-1 text-sm">
                        <option value="">All genre</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->content }}</option>
                        @endforeach

                    </select>
                    <input class="" type="text" name="keyword" placeholder="Search..." value="{{request('keyword')}}" class="border border-gray-300 rounded px-3 py-1 text-sm">
                    <input class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600 text-sm" type="submit" value="検索">
                </form>
            </div>
            @endif
        </div>
    </div>
</nav>