@extends('layouts.admin')

@section('title', 'Kelola Review')

@section('content')
<div class="mb-6 md:mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Kelola Review</h1>
</div>

<!-- Filter -->
<div class="bg-white rounded-xl shadow-md p-4 md:p-6 mb-4 md:mb-6">
    <form method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 md:gap-4">
        <select name="rating" class="px-3 md:px-4 py-2 md:py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 text-sm md:text-base">
            <option value="">Semua Rating</option>
            <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐</option>
            <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐</option>
            <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐</option>
            <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>⭐⭐</option>
            <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>⭐</option>
        </select>
        <button type="submit" class="bg-red-800 hover:bg-red-900 text-white px-4 md:px-6 py-2 md:py-2.5 rounded-lg font-semibold hover:shadow-lg transition text-sm md:text-base">
            Filter
        </button>
        @if(request('rating'))
            <a href="/admin/reviews" class="bg-gray-200 text-gray-700 px-4 md:px-6 py-2 md:py-2.5 rounded-lg font-semibold hover:bg-gray-300 transition text-center text-sm md:text-base">
                Reset
            </a>
        @endif
    </form>
</div>

@if($reviews->count() > 0)
    <div class="space-y-3 md:space-y-4">
        @foreach($reviews as $review)
            <div class="bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-lg transition">
                <div class="flex items-start justify-between mb-3 md:mb-4">
                    <div class="flex items-center flex-1 min-w-0">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-linear-to-br from-red-800 to-red-900 rounded-full flex items-center justify-center text-white font-bold mr-3 md:mr-4 shrink-0">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-bold text-sm md:text-base text-gray-800 truncate">{{ $review->user->name }}</p>
                            <p class="text-xs md:text-sm text-gray-600 truncate">{{ $review->user->email }}</p>
                        </div>
                    </div>
                    <span class="text-xs md:text-sm text-gray-500 whitespace-nowrap ml-2">{{ $review->created_at->format('d M Y') }}</span>
                </div>

                <div class="md:ml-16">
                    <!-- Product -->
                    <div class="mb-2 md:mb-3">
                        <span class="bg-gray-100 text-gray-700 px-2 md:px-3 py-1 rounded-full text-xs md:text-sm font-semibold">
                            {{ $review->product->name }}
                        </span>
                    </div>

                    <!-- Rating -->
                    <div class="flex mb-2 md:mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endif
                        @endfor
                    </div>

                    <!-- Comment -->
                    @php
                        $defaultMessages = [
                            1 => 'Tidak sesuai harapan.',
                            2 => 'Kurang memuaskan, ada yang perlu ditingkatkan.',
                            3 => 'Cukup baik, sesuai dengan harga.',
                            4 => 'Memuaskan, produk enak dan sesuai ekspektasi.',
                            5 => 'Sangat puas! Produk sangat enak dan berkualitas.'
                        ];
                        $displayComment = $review->comment ?: $defaultMessages[$review->rating];
                    @endphp
                    <p class="text-xs md:text-sm lg:text-base text-gray-700 leading-relaxed">{{ $displayComment }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $reviews->links() }}
    </div>
@else
    <div class="bg-white rounded-xl shadow-md p-8 md:p-12 text-center">
        <div class="text-6xl md:text-8xl mb-4 md:mb-6">⭐</div>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3 md:mb-4">Tidak Ada Review</h3>
        <p class="text-sm md:text-base text-gray-600">Belum ada review dari customer</p>
    </div>
@endif
@endsection
