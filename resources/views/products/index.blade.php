@extends('layouts.app')

@section('title', 'Menu - Rice Berapi')

@section('content')

<!-- Header Section -->
<section class="bg-red-800 text-white py-8 md:py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold mb-2">Menu Kami</h1>
        <p class="text-red-100 text-sm md:text-base">Temukan berbagai pilihan nasi bakar yang lezat</p>
    </div>
</section>

<!-- Filter dan Search Section -->
<section class="bg-white shadow py-4 md:py-6">
    <div class="container mx-auto px-4">
        <form method="GET" action="/menu" class="flex flex-col sm:flex-row gap-3 md:gap-4 items-stretch">
            <!-- Search -->
            <div class="flex-1">
                <input type="text" name="search" placeholder="Cari menu..." 
                       value="{{ request('search') }}"
                       class="w-full h-10 md:h-11 px-3 md:px-4 text-sm md:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800">
            </div>

            <!-- Filter Kategori -->
            <div class="sm:w-48 md:w-56 lg:w-64">
                <select name="category" class="w-full h-10 md:h-11 px-3 md:px-4 text-sm md:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 appearance-none bg-white cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Button -->
            <button type="submit" class="bg-red-800 text-white h-10 md:h-11 px-5 md:px-6 lg:px-8 text-sm md:text-base rounded-lg font-semibold hover:bg-red-900 hover:shadow-lg transition cursor-pointer whitespace-nowrap">
                Filter
            </button>

            @if(request('search') || request('category'))
                <a href="/menu" class="bg-gray-200 text-gray-700 h-10 md:h-11 px-5 md:px-6 lg:px-8 text-sm md:text-base rounded-lg font-semibold hover:bg-gray-300 transition cursor-pointer whitespace-nowrap flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>
</section>

<!-- Products Grid -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-2xl transform hover:-translate-y-2 transition duration-300 overflow-hidden">
                        <!-- Gambar Produk -->
                        <div class="h-56 bg-linear-to-br from-red-100 to-orange-100 flex items-center justify-center overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-7xl">🍱</span>
                            @endif
                        </div>

                        <!-- Info Produk -->
                        <div class="p-5">
                            <div class="mb-2">
                                <span class="bg-orange-100 text-orange-600 text-xs px-3 py-1 rounded-full font-semibold">
                                    {{ ucfirst($product->category) }}
                                </span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>
                            
                            <!-- Rating -->
                            <div class="flex items-center mb-4">
                                <div class="flex mr-2">
                                    @php
                                        $avgRating = $product->reviews_avg_rating ? round($product->reviews_avg_rating) : 0;
                                    @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $avgRating)
                                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-600">
                                    @if($product->reviews_avg_rating)
                                        {{ number_format($product->reviews_avg_rating, 1) }}
                                    @else
                                        0.0
                                    @endif
                                    ({{ $product->reviews_count }})
                                </span>
                            </div>

                            <!-- Price and Stock -->
                            <div class="mb-3">
                                <span class="text-xl md:text-2xl font-bold text-red-800">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <p class="text-xs md:text-sm text-gray-500">Stok: {{ $product->stock }}</p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <a href="/menu/{{ $product->id }}" class="flex-1 inline-flex items-center justify-center bg-white border-2 border-red-800 text-red-800 px-4 py-2 rounded-lg font-semibold hover:bg-red-50 transition text-sm md:text-base cursor-pointer">
                                    Detail
                                </a>
                                @if(session('user_id'))
                                    <form action="/cart/add" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="w-full inline-flex items-center justify-center bg-red-800 border-2 border-red-800 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-900 hover:border-red-900 transition text-sm md:text-base cursor-pointer">
                                            Pesan
                                        </button>
                                    </form>
                                @else
                                    <a href="/login?redirect=order" class="flex-1 inline-flex items-center justify-center bg-red-800 border-2 border-red-800 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-900 hover:border-red-900 transition text-sm md:text-base cursor-pointer">
                                        Pesan
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12 md:py-16">
                <div class="text-5xl md:text-6xl mb-4">🔍</div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">Produk Tidak Ditemukan</h3>
                <p class="text-gray-600 mb-4 md:mb-6 text-sm md:text-base">Coba cari dengan kata kunci atau kategori lain</p>
                <a href="/menu" class="inline-block bg-red-800 text-white px-5 md:px-6 py-2 md:py-3 rounded-lg font-semibold hover:bg-red-900 hover:shadow-lg transition cursor-pointer">
                    Lihat Semua Menu
                </a>
            </div>
        @endif
    </div>
</section>

@endsection
