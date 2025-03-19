<nav class="bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 pt-4">
        <div class="flex justify-between px-8 md:px-8 lg:px-6 gap-4 items-center">
            <div class="flex items-center">
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
                    <div class="flex-shrink-0 flex items-center ml-2">
                        <a href="{{ route('home') }}" class="text-blue-600 text-xl font-bold">
                            Rese
                        </a>
                    </div>
                </div>
            </div>
            @if (Auth::check() && Route::is('home','search'))
            <div class="md:flex md:ml-auto items-center">
                <form class="flex items-center bg-white px-4 py-2 rounded shadow-md gap-4 w-[500px]" action="/search" method="get">
                    @csrf
                    <div class="relative">
                        <select name="area_id" class="appearance-none bg-white border-none rounded px-3 py-2 text-sm pr-6">
                            <option value="">All area</option>
                            @foreach ($areas as $area)
                            <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="relative">
                        <select name="category_id" class="appearance-none bg-white border-none rounded px-3 py-2 text-sm pr-6">
                            <option value="">All genre</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->content }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input class="" type="text" name="keyword" placeholder="Search..." value="{{request('keyword')}}" class="border border-gray-300 rounded px-3 py-2 text-sm flex-1">
                </form>
            </div>
            @endif
        </div>
    </div>
</nav>