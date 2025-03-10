<x-guest-layout>
    @include('layouts.navigation')
    <div class="flex min-h-screen bg-gray-100 justify-center items-center px-4">
        <div class="w-full max-w-md">
            <div class="relative bg-white shadow-md rounded-md">

                <!-- タイトルバー -->
                <div class="bg-blue-600 text-white text-lg font-bold rounded-t-md px-4 py-4">
                    Registeration
                </div>

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('register') }}" class="relative bg-white shadow-md rounded-b-md px-4 py-4">
                    @csrf

                    <!-- Name -->
                    <div class="flex items-center py-2">
                        <span class="text-gray-600 text-lg mr-2">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <x-input id="name"
                            class="block w-full border-none border-b-2 focus:border-blue-500 focus:outline-none bg-transparent"
                            type="text" name="name" :value="old('name')" autofocus placeholder="name" />
                    </div>

                    <!-- Email Address -->
                    <div class="flex items-center py-2">
                        <span class="text-gray-600 text-lg mr-2">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <x-input id="email"
                            class="block w-full border-none border-b-2 focus:border-blue-500 focus:outline-none bg-transparent"
                            type="email" name="email" :value="old('email')" placeholder="Email" />
                    </div>

                    <!-- Password -->
                    <div class="flex items-center py-2 mt-4">
                        <span class="text-gray-600 text-lg mr-2">
                            <i class="fas fa-lock"></i>
                        </span>
                        <x-input id="password"
                            class="block w-full border-none border-b-2 focus:border-blue-500 focus:outline-none bg-transparent"
                            type="password" name="password" autocomplete="current-password"
                            placeholder="Password" />
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                            登録
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>