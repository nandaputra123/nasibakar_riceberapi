@extends('layouts.app')

@section('title', 'Tulis Review - Rice Berapi')

@section('content')
<section class="py-8 md:py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Tulis Review</h1>
            <p class="text-gray-600 text-sm md:text-base">Bagikan pengalaman Anda tentang produk yang telah Anda beli</p>
        </div>

        @if(count($reviewableProducts) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                @foreach($reviewableProducts as $item)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition overflow-hidden">
                        <div class="p-4 md:p-6">
                            <!-- Product Info -->
                            <div class="flex items-start space-x-4 mb-4">
                                <div class="w-20 h-20 md:w-24 md:h-24 bg-linear-to-br from-red-100 to-orange-100 rounded-lg flex items-center justify-center shrink-0 overflow-hidden">
                                    @if($item['product']->image)
                                        <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-4xl">🍱</span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-gray-800 text-base md:text-lg mb-1 line-clamp-2">{{ $item['product']->name }}</h3>
                                    <p class="text-gray-600 text-xs md:text-sm mb-2 line-clamp-2">{{ $item['product']->description }}</p>
                                    <div class="flex items-center space-x-2 text-xs md:text-sm text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        <span>{{ $item['order']->order_code }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Date -->
                            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                <div class="flex items-center justify-between text-xs md:text-sm">
                                    <span class="text-gray-600">Tanggal Pemesanan</span>
                                    <span class="font-semibold text-gray-800">{{ $item['order']->created_at->format('d M Y') }}</span>
                                </div>
                            </div>

                            <!-- Review Button -->
                            <a href="/reviews/create/{{ $item['order']->id }}/{{ $item['product']->id }}" 
                               class="block w-full bg-linear-to-r from-yellow-500 to-orange-500 text-white font-bold py-3 px-4 rounded-lg hover:from-yellow-600 hover:to-orange-600 hover:shadow-lg transition duration-200 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                    <span>Tulis Review</span>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-md p-8 md:p-12 text-center">
                <div class="w-20 h-20 md:w-24 md:h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 md:w-12 md:h-12 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                    </svg>
                </div>
                <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3 md:mb-4">Tidak Ada Produk untuk Direview</h3>
                <p class="text-gray-600 mb-6 md:mb-8 text-sm md:text-base max-w-md mx-auto">
                    Anda belum memiliki pesanan yang selesai atau sudah memberikan review untuk semua produk yang dibeli
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center max-w-md mx-auto">
                    <a href="/menu" class="flex-1 bg-red-800 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-900 transition text-center">
                        Belanja Sekarang
                    </a>
                    <a href="/orders" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition text-center">
                        Lihat Pesanan
                    </a>
                </div>
            </div>
        @endif

        <!-- Info Box -->
        @if(count($reviewableProducts) > 0)
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4 md:p-6">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800 mb-2 text-sm md:text-base">Mengapa Review Penting?</h4>
                        <ul class="text-gray-700 text-xs md:text-sm space-y-1">
                            <li>✓ Membantu customer lain membuat keputusan pembelian</li>
                            <li>✓ Memberikan feedback kepada kami untuk meningkatkan kualitas produk</li>
                            <li>✓ Review Anda sangat berharga bagi kami</li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
