@extends('layouts.app')

@section('title', 'Keranjang Belanja - Rice Berapi')

@section('content')

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6 md:p-8 transform transition-all scale-95" id="deleteModalContent">
        <div class="text-center mb-6">
            <div class="mx-auto flex items-center justify-center h-12 w-12 md:h-16 md:w-16 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 md:h-8 md:w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-2">Hapus Item?</h3>
            <p class="text-sm md:text-base text-gray-600">Yakin ingin menghapus item ini dari keranjang belanja?</p>
        </div>
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()" class="flex-1 bg-gray-200 text-gray-700 font-semibold h-11 md:h-12 px-4 rounded-lg hover:bg-gray-300 transition text-sm md:text-base">
                Batal
            </button>
            <button onclick="confirmDelete()" class="flex-1 bg-red-600 text-white font-bold h-11 md:h-12 px-4 rounded-lg hover:bg-red-700 transition text-sm md:text-base">
                Hapus
            </button>
        </div>
    </div>
</div>

<section class="py-8 md:py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6 md:mb-8">Keranjang Belanja</h1>

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-white rounded-xl shadow-md p-4 md:p-5 lg:p-6">
                            <div class="flex flex-col sm:flex-row gap-4 md:gap-5 lg:gap-6">
                                <!-- Product Image -->
                                <div class="w-full sm:w-24 md:w-28 lg:w-32 h-24 sm:h-24 md:h-28 lg:h-32 bg-linear-to-br from-red-100 to-orange-100 rounded-lg flex items-center justify-center shrink-0 overflow-hidden">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-4xl md:text-5xl lg:text-6xl">🍱</span>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-3">
                                        <h3 class="text-base md:text-lg lg:text-xl font-bold text-gray-800">{{ $item->product->name }}</h3>
                                        <!-- Delete Button (Desktop) -->
                                        <button type="button" onclick="showDeleteModal({{ $item->id }})" class="hidden sm:block text-red-600 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition" title="Hapus">
                                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                        <!-- Hidden Delete Form -->
                                        <form id="deleteForm{{ $item->id }}" action="/cart/{{ $item->id }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                    <p class="text-gray-600 mb-3 text-xs md:text-sm lg:text-base line-clamp-2">{{ $item->product->description }}</p>
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                        <div class="flex items-center justify-between sm:justify-start gap-4">
                                            <p class="text-lg md:text-xl lg:text-2xl font-bold text-red-800">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                            <p class="text-xs md:text-sm text-gray-500">Stok: {{ $item->product->stock }}</p>
                                        </div>
                                        
                                        <!-- Quantity Controls -->
                                        <div class="flex items-center gap-3">
                                            <span class="text-sm md:text-base text-gray-700 font-semibold">Jumlah:</span>
                                            <form action="/cart/{{ $item->id }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                                    <button type="button" onclick="decrementQty({{ $item->id }})" class="bg-gray-100 hover:bg-gray-200 text-gray-700 w-8 h-9 md:w-9 md:h-10 flex items-center justify-center transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                    </button>
                                                    <input type="number" id="qty{{ $item->id }}" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" 
                                                           class="w-10 md:w-12 h-9 md:h-10 text-center text-sm md:text-base font-semibold bg-white border-l border-r border-gray-300 focus:outline-none" readonly>
                                                    <button type="button" onclick="incrementQty({{ $item->id }}, {{ $item->product->stock }})" class="bg-gray-100 hover:bg-gray-200 text-gray-700 w-8 h-9 md:w-9 md:h-10 flex items-center justify-center transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold h-9 md:h-10 px-3 md:px-4 rounded-lg transition text-xs md:text-sm whitespace-nowrap">
                                                    Update
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Delete Button (Mobile) -->
                            <button type="button" onclick="showDeleteModal({{ $item->id }})" class="sm:hidden mt-4 w-full bg-red-50 text-red-600 hover:bg-red-100 h-10 md:h-11 px-4 rounded-lg transition font-semibold text-sm md:text-base flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus dari Keranjang
                            </button>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-4 md:p-6 lg:sticky lg:top-24">
                        <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-4 md:mb-6">Ringkasan Pesanan</h3>
                        
                        <div class="space-y-2 md:space-y-3 mb-4 md:mb-6 max-h-48 overflow-y-auto">
                            @foreach($cartItems as $item)
                                <div class="flex justify-between text-gray-700 text-sm md:text-base gap-2">
                                    <span class="flex-1 min-w-0">{{ $item->product->name }} (x{{ $item->quantity }})</span>
                                    <span class="whitespace-nowrap">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-200 pt-3 md:pt-4 mb-4 md:mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-lg md:text-xl font-bold text-gray-800">Total</span>
                                <span class="text-2xl md:text-3xl font-bold text-red-800">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <a href="/checkout" class="w-full bg-red-800 text-white font-bold h-11 md:h-12 px-4 md:px-6 rounded-lg text-center hover:bg-red-900 hover:shadow-xl transition duration-200 flex items-center justify-center text-sm md:text-base">
                            Checkout
                        </a>

                        <a href="/menu" class="w-full bg-gray-200 text-gray-700 font-semibold h-10 md:h-11 px-4 md:px-6 rounded-lg text-center hover:bg-gray-300 transition mt-3 flex items-center justify-center text-sm md:text-base">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="bg-white rounded-xl shadow-md p-8 md:p-12 text-center">
                <div class="text-6xl md:text-8xl mb-4 md:mb-6">🛒</div>
                <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3 md:mb-4">Keranjang Anda Kosong</h3>
                <p class="text-gray-600 mb-6 md:mb-8 text-base md:text-lg">Belum ada produk di keranjang. Yuk, mulai belanja!</p>
                <a href="/menu" class="inline-flex items-center justify-center bg-red-800 text-white font-bold h-12 md:h-14 px-6 md:px-8 rounded-lg hover:bg-red-900 hover:shadow-xl transition duration-200 text-sm md:text-base">
                    Lihat Menu
                </a>
            </div>
        @endif
    </div>
</section>

<script>
    let deleteItemId = null;

    function showDeleteModal(itemId) {
        deleteItemId = itemId;
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('deleteModalContent');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100', 'pointer-events-auto', 'flex');
        modalContent.classList.remove('scale-95');
        modalContent.classList.add('scale-100');
    }

    function closeDeleteModal() {
        deleteItemId = null;
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('deleteModalContent');
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.classList.remove('opacity-100', 'pointer-events-auto', 'flex');
        modalContent.classList.add('scale-95');
        modalContent.classList.remove('scale-100');
    }

    function confirmDelete() {
        if (deleteItemId) {
            document.getElementById('deleteForm' + deleteItemId).submit();
        }
    }

    function incrementQty(itemId, maxStock) {
        const qtyInput = document.getElementById('qty' + itemId);
        let currentValue = parseInt(qtyInput.value);
        if (currentValue < maxStock) {
            qtyInput.value = currentValue + 1;
        }
    }

    function decrementQty(itemId) {
        const qtyInput = document.getElementById('qty' + itemId);
        let currentValue = parseInt(qtyInput.value);
        if (currentValue > 1) {
            qtyInput.value = currentValue - 1;
        }
    }

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>

@endsection
