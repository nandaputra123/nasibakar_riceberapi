@extends('layouts.app')

@section('title', 'Pesanan Berhasil - Rice Berapi')

@section('content')
<section class="py-8 md:py-12 bg-linear-to-br from-green-50 to-blue-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <!-- Success Card -->
            <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 text-center">
                <div class="w-20 h-20 md:w-24 md:h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 md:mb-6">
                    <svg class="w-10 h-10 md:w-12 md:h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-3 md:mb-4">Pesanan Berhasil!</h1>
                <p class="text-gray-600 text-base md:text-lg mb-6 md:mb-8">Terima kasih telah memesan di Rice Berapi</p>

                <!-- Order Code -->
                <div class="bg-gray-50 rounded-lg p-4 md:p-6 mb-6 md:mb-8">
                    <p class="text-gray-600 mb-2 text-sm md:text-base">Kode Pesanan</p>
                    <p class="text-2xl md:text-3xl font-bold text-red-800">{{ $order->order_code }}</p>
                </div>

                <!-- Order Info -->
                <div class="bg-gray-50 rounded-lg p-4 md:p-6 mb-6 md:mb-8 text-left">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-3 md:mb-4">Detail Pesanan</h3>
                    
                    @foreach($order->orderItems as $item)
                        <div class="flex justify-between py-2 border-b border-gray-200 gap-4">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 text-sm md:text-base">{{ $item->product_name }}</p>
                                <p class="text-xs md:text-sm text-gray-600">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <span class="font-bold text-gray-800 text-sm md:text-base whitespace-nowrap">Rp {{ number_format($item->subtotal(), 0, ',', '.') }}</span>
                        </div>
                    @endforeach

                    <div class="flex justify-between py-3 mt-3">
                        <span class="text-base md:text-lg font-bold text-gray-800">Total</span>
                        <span class="text-xl md:text-2xl font-bold text-red-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 md:p-6 mb-6 md:mb-8 text-left">
                    <h3 class="text-base md:text-lg font-bold text-gray-800 mb-2">Metode Pembayaran</h3>
                    <p class="text-gray-700 text-sm md:text-base">{{ $order->payment->method == 'cash' ? 'Cash on Delivery (COD)' : 'Transfer Bank' }}</p>
                    
                    @if($order->payment->method == 'transfer')
                        <div class="mt-4 bg-white rounded p-3 md:p-4">
                            <p class="text-xs md:text-sm text-gray-600 mb-2">Silakan transfer ke:</p>
                            <p class="font-bold text-gray-800 text-sm md:text-base">Bank BCA - 1234567890</p>
                            <p class="font-bold text-gray-800 text-sm md:text-base">a.n. Rice Berapi</p>
                            <p class="text-xs md:text-sm text-gray-600 mt-2">Pesanan akan diproses setelah pembayaran dikonfirmasi oleh admin</p>
                        </div>
                        
                        @if(!$order->payment->proof_of_transfer)
                            <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded p-3 md:p-4">
                                <p class="text-yellow-800 text-xs md:text-sm mb-2 font-semibold">
                                    ⚠️ Jangan lupa upload bukti transfer
                                </p>
                                <form action="/orders/{{ $order->id }}/upload-proof" method="POST" enctype="multipart/form-data" class="mt-2">
                                    @csrf
                                    <label class="block">
                                        <span class="text-xs md:text-sm text-gray-700 mb-1 block">Pilih file bukti transfer:</span>
                                        <input type="file" name="proof_of_transfer" accept="image/jpeg,image/jpg,image/png" required 
                                            class="block w-full text-xs md:text-sm text-gray-700 file:mr-2 md:file:mr-4 file:py-1.5 md:file:py-2 file:px-3 md:file:px-4 file:rounded-lg file:border-0 file:text-xs md:file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 file:cursor-pointer">
                                    </label>
                                    <button type="submit" class="mt-2 w-full bg-red-800 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-lg font-semibold hover:bg-red-900 transition text-xs md:text-sm">
                                        Upload Bukti Transfer
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="mt-4 bg-green-50 border border-green-200 rounded p-3 md:p-4">
                                <p class="text-green-800 text-xs md:text-sm font-semibold">
                                    ✓ Bukti transfer sudah diupload, menunggu verifikasi admin
                                </p>
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3 md:gap-4">
                    <a href="/orders/{{ $order->id }}" class="flex-1 bg-red-800 text-white font-semibold py-2.5 px-4 rounded-lg hover:bg-red-900 hover:shadow-lg transition text-center text-sm">
                        Lihat Detail Pesanan
                    </a>
                    <button onclick="openInvoiceModal()" class="flex-1 bg-green-600 text-white font-semibold py-2.5 px-4 rounded-lg hover:bg-green-700 hover:shadow-lg transition inline-flex items-center justify-center text-sm">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Lihat Invoice
                    </button>
                    <a href="/menu" class="flex-1 bg-gray-200 text-gray-700 font-semibold py-2.5 px-4 rounded-lg hover:bg-gray-300 transition text-center text-sm">
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Invoice -->
<div id="invoiceModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[85vh] flex flex-col">
        <div class="flex justify-between items-center p-3 md:p-4 border-b border-gray-200">
            <h3 class="text-base md:text-lg font-bold text-gray-800">Preview Invoice</h3>
            <button onclick="closeInvoiceModal()" class="text-gray-500 hover:text-gray-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto overflow-x-hidden">
            <iframe src="/orders/{{ $order->id }}/invoice" class="w-full border-0" style="height: 900px;"></iframe>
        </div>
        <div class="p-3 md:p-4 border-t border-gray-200 flex flex-col sm:flex-row gap-2 justify-end">
            <button onclick="closeInvoiceModal()" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition text-xs md:text-sm">
                Tutup
            </button>
            <a href="/orders/{{ $order->id }}/invoice/download" class="inline-flex items-center justify-center px-3 py-2 bg-red-800 text-white rounded-lg font-semibold hover:bg-red-900 transition text-xs md:text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeInvoiceModal() {
    const modal = document.getElementById('invoiceModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

document.getElementById('invoiceModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeInvoiceModal();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeInvoiceModal();
    }
});
</script>
@endsection
