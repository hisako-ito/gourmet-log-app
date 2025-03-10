@section('css')
<link rel="stylesheet" href="{{ asset('/css/navigation.css')  }}">
@endsection


<nav class="bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16">
            <div class="flex items-center">
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="bg-blue-600 text-white focus:outline-none rounded-md shadow-md w-24 p-2">
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
                                <button type="submit" class="w-full text-left px-4 py-2 text-blue-600 hover:bg-gray-100">
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
        </div>
    </div>
</nav>