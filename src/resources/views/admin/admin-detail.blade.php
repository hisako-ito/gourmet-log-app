<x-app-layout>
    @section('title','店舗詳細')
    <div class="py-4 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="w-full flex justify-center">
                <div class="flex flex-col gap-4 w-full max-w-xl px-8">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="mr-2">
                            <button class="bg-white text-xl px-3 py-1 rounded shadow-md"><i class="fa-solid fa-chevron-left"></i></button></a>
                        <h2 class="inline text-xl font-bold">{{ $shop->name }}</h2>
                    </div>
                    <img src="{{ asset('storage/' . $shop->image) }}" alt="店舗画像" class="w-full h-[300px] object-cover rounded shadow-md" />
                    <div>
                        <p class="">#{{ $shop->area->name }}&nbsp#{{ $shop->category->content }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">店舗詳細</h3>
                        <p class="ml-4 leading-relaxed">{{ $shop->description }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">コース一覧</h3>
                        <ul class="ml-4">
                            @foreach($courses as $course)
                            <li>{{ $course->name }}：{{ $course->price }}円 {{ $course->description }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="">
                        <h3 class="text-lg font-bold">評価</h3>
                        @foreach ($shop->reviews as $review)
                        <div class="flex flex-col gap-2 p-2 mt-2">
                            <p class="">{{ $review->user->name }}様<span class="text-xs ml-2">{{ \Carbon\Carbon::parse($review->reservation->date)->format('Y/m') }}訪問</span></p>
                            <div class="flex text-yellow-400 min-h-[24px]">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <=$review->rating)
                                    <i class="fas fa-star"></i>
                                    @else
                                    <i class="far fa-star text-gray-300"></i>
                                    @endif
                                    @endfor
                            </div>
                            <div class="bg-white w-full rounded p-2 min-h-[24px] text-sm">
                                {{ $review->comment ? $review->comment : 'コメントはありません' }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>