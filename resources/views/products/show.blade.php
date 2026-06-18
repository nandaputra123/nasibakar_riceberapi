@extends('layouts.app')

@section('title', $product->name . ' - Rice Berapi')

@section('content')

<section class="py-6 md:py-10 lg:py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 lg:gap-8 p-4 md:p-6 lg:p-8">
                <!-- Gambar Produk -->
                <div>
                    <div class="aspect-square bg-linear-to-br from-red-100 to-orange-100 rounded-xl flex items-center justify-center overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-6xl md:text-7xl lg:text-9xl">🍱</span>
                        @endif
                    </div>
                </div>

                <!-- Detail Produk -->
                <div>
                    <div class="mb-3">
                        <span class="bg-orange-100 text-orange-600 text-xs md:text-sm px-3 md:px-4 py-1.5 md:py-2 rounded-full font-semibold">
                            {{ ucfirst($product->category) }}
                        </span>
                    </div>

                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>

                    <!-- Rating -->
                    <div class="flex items-center mb-4 md:mb-6">
                        <div class="flex mr-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($averageRating))
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
                        <span class="text-gray-600 text-xs md:text-sm lg:text-base">{{ number_format($averageRating, 1) }} ({{ $reviewCount }} review)</span>
                    </div>

                    <p class="text-gray-700 text-sm md:text-base lg:text-lg mb-6 leading-relaxed">{{ $product->description }}</p>

                    <div class="border-t border-b border-gray-200 py-4 md:py-5 lg:py-6 mb-4 md:mb-5 lg:mb-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-600 text-xs md:text-sm mb-1">Harga</p>
                                <p class="text-2xl md:text-3xl lg:text-4xl font-bold text-red-800">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-600 text-xs md:text-sm mb-1">Stok Tersedia</p>
                                <p class="text-lg md:text-xl lg:text-2xl font-bold text-gray-800">{{ $product->stock }} porsi</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Add to Cart -->
                    @if(session('user_id'))
                        @if($product->stock > 0)
                            <form action="/cart/add" method="POST" class="mb-4">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <div class="flex items-center space-x-3 mb-4">
                                    <label class="text-gray-700 text-sm md:text-base font-semibold">Jumlah:</label>
                                    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                        <button type="button" onclick="decrementQty()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 w-8 h-8 md:w-10 md:h-10 flex items-center justify-center transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" readonly
                                               class="w-12 md:w-16 h-8 md:h-10 text-center text-sm md:text-base border-l border-r border-gray-300 focus:outline-none bg-white">
                                        <button type="button" onclick="incrementQty()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 w-8 h-8 md:w-10 md:h-10 flex items-center justify-center transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <button type="submit" class="w-full bg-red-800 text-white text-sm md:text-base font-bold h-11 md:h-12 px-4 md:px-6 rounded-lg hover:bg-red-900 hover:shadow-xl transition duration-200">
                                    Tambah ke Keranjang
                                </button>
                            </form>
                        @else
                            <div class="bg-red-100 text-red-700 text-sm md:text-base px-3 md:px-4 py-2 md:py-3 rounded-lg mb-4">
                                Stok habis, silakan pesan lain waktu
                            </div>
                        @endif
                    @else
                        <a href="/login?redirect=order" class="w-full bg-red-800 text-white text-sm md:text-base font-bold h-11 md:h-12 px-4 md:px-6 rounded-lg hover:bg-red-900 hover:shadow-xl transition duration-200 mb-4 flex items-center justify-center">
                            Login untuk Memesan
                        </a>
                    @endif

                    <a href="/menu" class="w-full bg-gray-200 text-gray-700 text-sm md:text-base font-semibold h-11 md:h-12 px-4 md:px-6 rounded-lg hover:bg-gray-300 transition flex items-center justify-center">
                        Kembali ke Menu
                    </a>
                </div>
            </div>

            <!-- Reviews Section -->
            @if($product->reviews->count() > 0)
                <div class="border-t border-gray-200 p-4 md:p-6 lg:p-8">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-4 md:mb-6">Review Pelanggan</h3>
                    <div class="space-y-4 md:space-y-6">
                        @foreach($product->reviews as $review)
                            <div class="bg-gray-50 rounded-lg p-3 md:p-4 lg:p-5">
                                <div class="flex items-start justify-between mb-2 md:mb-3">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 md:w-10 md:h-10 bg-linear-to-br from-red-800 to-red-900 rounded-full flex items-center justify-center text-white text-sm md:text-base font-bold mr-2 md:mr-3">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm md:text-base font-semibold text-gray-800">{{ $review->user->name }}</p>
                                            <div class="flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <svg class="w-3 h-3 md:w-4 md:h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                        </svg>
                                                    @else
                                                        <svg class="w-3 h-3 md:w-4 md:h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                        </svg>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-xs md:text-sm text-gray-500 whitespace-nowrap ml-2">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
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
                                <p class="text-sm md:text-base text-gray-700">{{ $displayComment }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Produk Terkait -->
        @if($relatedProducts->count() > 0)
            <div class="mt-8 md:mt-10 lg:mt-12">
                <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-4 md:mb-6">Produk Terkait</h3>
                <!-- Mobile/Tablet View -->
                <div class="grid grid-cols-2 gap-3 md:gap-4 lg:hidden">
                    @foreach($relatedProducts->take(4) as $related)
                        <a href="/menu/{{ $related->id }}" class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden">
                            <div class="aspect-square bg-linear-to-br from-red-100 to-orange-100 flex items-center justify-center">
                                @if($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-4xl md:text-5xl">🍱</span>
                                @endif
                            </div>
                            <div class="p-2 md:p-3">
                                <p class="text-xs md:text-sm font-semibold text-gray-800 line-clamp-1 mb-1">{{ $related->name }}</p>
                                <p class="text-xs md:text-sm font-bold text-red-800">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
                <!-- Desktop View -->
                <div class="hidden lg:grid grid-cols-4 gap-4 md:gap-6">
                    @foreach($relatedProducts as $related)
                        <a href="/menu/{{ $related->id }}" class="bg-white rounded-xl shadow-md hover:shadow-xl transform hover:-translate-y-2 transition duration-300 overflow-hidden">
                            <div class="h-40 md:h-48 bg-linear-to-br from-red-100 to-orange-100 flex items-center justify-center">
                                @if($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-5xl md:text-6xl">🍱</span>
                                @endif
                            </div>
                            <div class="p-3 md:p-4">
                                <p class="font-bold text-gray-800 mb-2 line-clamp-2 text-sm md:text-base">{{ $related->name }}</p>
                                <p class="text-base md:text-lg font-bold text-red-800">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

<script>
    const maxStock = {{ $product->stock }};
    
    function incrementQty() {
        const qtyInput = document.getElementById('quantity');
        let currentValue = parseInt(qtyInput.value);
        if (currentValue < maxStock) {
            qtyInput.value = currentValue + 1;
        }
    }
    
    function decrementQty() {
        const qtyInput = document.getElementById('quantity');
        let currentValue = parseInt(qtyInput.value);
        if (currentValue > 1) {
            qtyInput.value = currentValue - 1;
        }
    }
</script>

@endsection
