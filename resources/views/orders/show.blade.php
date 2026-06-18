@extends('layouts.app')

@section('title', 'Detail Pesanan - Rice Berapi')

@section('content')
<section class="py-8 md:py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <a href="/orders" class="inline-flex items-center text-red-800 hover:text-red-900 mb-6 font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Riwayat Pesanan
        </a>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-red-800 text-white p-4 md:p-6 lg:p-8">
                <div class="flex flex-col gap-3 md:gap-4">
                    <div class="flex flex-col">
                        <p class="text-red-100 mb-1 text-xs md:text-sm">Kode Pesanan</p>
                        <h1 class="text-xl md:text-2xl lg:text-3xl font-bold break-all">{{ $order->order_code }}</h1>
                        <p class="text-red-100 mt-1.5 text-xs md:text-sm">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-2">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-500',
                                'processing' => 'bg-blue-500',
                                'ready' => 'bg-purple-500',
                                'completed' => 'bg-green-500',
                                'cancelled' => 'bg-red-500',
                            ];
                            $statusLabels = [
                                'pending' => 'Menunggu',
                                'processing' => 'Diproses',
                                'ready' => 'Siap',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ];
                        @endphp
                        <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-full font-semibold text-white text-xs {{ $statusColors[$order->status] ?? 'bg-gray-500' }}">
                            {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                        </span>
                        
                        <!-- Tombol View Invoice -->
                        <button onclick="openInvoiceModal()" class="inline-flex items-center justify-center px-3 py-1.5 bg-white text-red-800 rounded-lg font-semibold text-xs hover:bg-red-50 transition">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Lihat Invoice
                        </button>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="p-4 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
                    <!-- Pengiriman -->
                    <div class="bg-gray-50 rounded-lg p-3 md:p-4">
                        <h3 class="text-sm md:text-base font-bold text-gray-800 mb-2 md:mb-3">Informasi Pengiriman</h3>
                        <p class="text-gray-700 mb-1.5 text-xs md:text-sm"><span class="font-semibold">Alamat:</span></p>
                        <p class="text-gray-600 mb-2 md:mb-3 text-xs md:text-sm">{{ $order->shipping_address }}</p>
                        <p class="text-gray-700 text-xs md:text-sm"><span class="font-semibold">Telepon:</span> {{ $order->phone }}</p>
                    </div>

                    <!-- Pembayaran -->
                    <div class="bg-gray-50 rounded-lg p-3 md:p-4">
                        <h3 class="text-sm md:text-base font-bold text-gray-800 mb-2 md:mb-3">Pembayaran</h3>
                        <p class="text-gray-700 mb-1.5 text-xs md:text-sm"><span class="font-semibold">Metode:</span> {{ $order->payment->method == 'cash' ? 'Cash (COD)' : 'Transfer Bank' }}</p>
                        <p class="text-gray-700 mb-1.5 text-xs md:text-sm"><span class="font-semibold">Status:</span> 
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $order->payment->status == 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($order->payment->status) }}
                            </span>
                        </p>
                        
                        @if($order->payment->method == 'transfer')
                            @if($order->payment->proof_of_transfer)
                                <div class="mt-2 md:mt-3">
                                    <p class="text-gray-700 mb-1.5 text-xs md:text-sm font-semibold">Bukti Transfer:</p>
                                    <img src="{{ asset('storage/' . $order->payment->proof_of_transfer) }}" alt="Bukti Transfer" class="w-full max-w-xs rounded-lg border border-gray-300">
                                </div>
                            @elseif($order->payment->status != 'confirmed')
                                <div class="mt-2 md:mt-3 p-2 md:p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <p class="text-yellow-800 text-xs mb-2">
                                        <span class="font-semibold">⚠️ Upload Bukti Transfer</span><br>
                                        Silakan upload bukti transfer untuk verifikasi pembayaran
                                    </p>
                                    <form action="/orders/{{ $order->id }}/upload-proof" method="POST" enctype="multipart/form-data" class="mt-2">
                                        @csrf
                                        <label class="block">
                                            <span class="sr-only">Pilih file bukti transfer</span>
                                            <input type="file" name="proof_of_transfer" accept="image/jpeg,image/jpg,image/png" required 
                                                class="block w-full text-xs text-gray-700 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 file:cursor-pointer">
                                        </label>
                                        <button type="submit" class="mt-2 w-full bg-red-800 text-white px-3 py-1.5 rounded-lg font-semibold hover:bg-red-900 transition text-xs">
                                            Upload Bukti Transfer
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endif
                    </div>

                    <!-- Catatan -->
                    @if($order->note)
                        <div class="bg-gray-50 rounded-lg p-3 md:p-4">
                            <h3 class="text-sm md:text-base font-bold text-gray-800 mb-2 md:mb-3">Catatan</h3>
                            <p class="text-gray-700 text-xs md:text-sm">{{ $order->note }}</p>
                        </div>
                    @endif
                </div>

                <!-- Items -->
                <div class="mb-6 md:mb-8">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-3 md:mb-4">Detail Pesanan</h3>
                    <div class="space-y-3 md:space-y-4">
                        @foreach($order->orderItems as $item)
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between border-b border-gray-200 pb-3 md:pb-4 gap-3 md:gap-4">
                                <div class="flex items-center space-x-2 md:space-x-3 w-full sm:w-auto">
                                    <div class="w-12 h-12 md:w-14 md:h-14 bg-linear-to-br from-red-100 to-orange-100 rounded-lg flex items-center justify-center shrink-0">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <span class="text-xl md:text-2xl">🍱</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-bold text-gray-800 text-xs md:text-sm">{{ $item->product_name }}</p>
                                        <p class="text-xs text-gray-600">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="text-left sm:text-right w-full sm:w-auto">
                                    <p class="font-bold text-gray-800 text-sm md:text-base mb-1">Rp {{ number_format($item->subtotal(), 0, ',', '.') }}</p>
                                    @if($order->status == 'completed' && $item->product)
                                        @php
                                            $reviewed = \App\Models\Review::where('user_id', session('user_id'))
                                                ->where('product_id', $item->product_id)
                                                ->where('order_id', $order->id)
                                                ->exists();
                                        @endphp
                                        @if(!$reviewed)
                                            <a href="/reviews/create/{{ $order->id }}/{{ $item->product_id }}" class="text-xs text-red-800 hover:text-red-900 font-semibold inline-block">
                                                Beri Review
                                            </a>
                                        @else
                                            <span class="text-xs text-green-600 font-semibold">✓ Sudah direview</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Total -->
                <div class="bg-gray-50 rounded-lg p-3 md:p-4">
                    <div class="flex justify-between items-center gap-2">
                        <span class="text-base md:text-lg font-bold text-gray-800">Total Pembayaran</span>
                        <span class="text-lg md:text-2xl font-bold text-red-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Invoice -->
<div id="invoiceModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[85vh] flex flex-col">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-3 md:p-4 border-b border-gray-200">
            <h3 class="text-base md:text-lg font-bold text-gray-800">Preview Invoice</h3>
            <button onclick="closeInvoiceModal()" class="text-gray-500 hover:text-gray-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Modal Body - iframe -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden">
            <iframe id="invoiceFrame" src="/orders/{{ $order->id }}/invoice" class="w-full border-0" style="height: 900px;"></iframe>
        </div>
        
        <!-- Modal Footer -->
        <div class="p-3 md:p-4 border-t border-gray-200 flex flex-col sm:flex-row gap-2 justify-end">
            <button onclick="closeInvoiceModal()" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition text-xs md:text-sm">
                Tutup
            </button>
            <a href="/orders/{{ $order->id }}/invoice/download" class="inline-flex items-center justify-center px-3 py-2 bg-red-800 text-white rounded-lg font-semibold hover:bg-red-900 transition text-xs md:text-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Download PDF
            </a>
        </div>
    </div>
</div>

<script>
function openInvoiceModal() {
    const modal = document.getElementById('invoiceModal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeInvoiceModal() {
    const modal = document.getElementById('invoiceModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('invoiceModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeInvoiceModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeInvoiceModal();
    }
});
</script>
@endsection
