@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="mb-6 md:mb-8">
    <a href="/admin/orders" class="text-red-800 hover:text-red-900 font-semibold inline-flex items-center text-sm md:text-base transition">
        <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali
    </a>
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mt-3 md:mt-4">Detail Pesanan</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
    <!-- Order Info -->
    <div class="lg:col-span-2 space-y-4 md:space-y-6">
        <!-- Header Card -->
        <div class="bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-lg transition">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3 md:gap-4 mb-4">
                <div class="flex-1">
                    <p class="text-gray-600 text-xs md:text-sm mb-1">Kode Pesanan</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $order->order_code }}</p>
                    <p class="text-xs md:text-sm text-gray-600 mt-2">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-700',
                        'processing' => 'bg-blue-100 text-blue-700',
                        'ready' => 'bg-purple-100 text-purple-700',
                        'completed' => 'bg-green-100 text-green-700',
                        'cancelled' => 'bg-red-100 text-red-700',
                    ];
                @endphp
                <span class="px-3 md:px-4 py-1.5 md:py-2 rounded-full font-semibold text-sm md:text-base whitespace-nowrap {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <!-- Customer Info -->
            <div class="border-t border-gray-200 pt-3 md:pt-4">
                <h3 class="font-bold text-sm md:text-base text-gray-800 mb-2">Customer</h3>
                <p class="text-sm md:text-base text-gray-700">{{ $order->user->name }}</p>
                <p class="text-xs md:text-sm text-gray-600">{{ $order->user->email }}</p>
            </div>
        </div>

        <!-- Items Card -->
        <div class="bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-lg transition">
            <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-3 md:mb-4">Item Pesanan</h3>
            <div class="space-y-3 md:space-y-4">
                @foreach($order->orderItems as $item)
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 border-b border-gray-200 pb-3 md:pb-4 last:border-0 last:pb-0">
                        <div class="flex-1">
                            <p class="font-semibold text-sm md:text-base text-gray-800">{{ $item->product_name }}</p>
                            <p class="text-xs md:text-sm text-gray-600">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <p class="font-bold text-sm md:text-base text-gray-800">Rp {{ number_format($item->subtotal(), 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
            <div class="border-t-2 border-gray-200 pt-3 md:pt-4 mt-3 md:mt-4">
                <div class="flex justify-between items-center">
                    <span class="text-lg md:text-xl font-bold text-gray-800">Total</span>
                    <span class="text-2xl md:text-3xl font-bold text-red-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Shipping Info -->
        <div class="bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-lg transition">
            <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-3 md:mb-4">Informasi Pengiriman</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-xs md:text-sm text-gray-600 mb-1 font-semibold">Alamat:</p>
                    <p class="text-sm md:text-base text-gray-700">{{ $order->shipping_address }}</p>
                </div>
                <div>
                    <p class="text-xs md:text-sm text-gray-600 mb-1 font-semibold">Telepon:</p>
                    <p class="text-sm md:text-base text-gray-700">{{ $order->phone }}</p>
                </div>
                @if($order->note)
                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-xs md:text-sm text-gray-600 mb-1 font-semibold">Catatan:</p>
                        <p class="text-sm md:text-base text-gray-700">{{ $order->note }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Actions Card -->
    <div class="lg:col-span-1 space-y-4 md:space-y-6">
        <!-- Update Status -->
        <div class="bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-lg transition">
            <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-3 md:mb-4">Update Status</h3>
            <form action="/admin/orders/{{ $order->id }}/status" method="POST">
                @csrf
                @method('PATCH')
                <select name="status" required class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg mb-3 md:mb-4 focus:ring-2 focus:ring-red-800 focus:border-red-800 text-sm md:text-base">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Ready</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="w-full bg-red-800 hover:bg-red-900 text-white font-bold h-11 md:h-12 rounded-lg hover:shadow-lg transition text-sm md:text-base">
                    Update Status
                </button>
            </form>
        </div>

        <!-- Payment Info -->
        <div class="bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-lg transition">
            <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-3 md:mb-4">Pembayaran</h3>
            <div class="space-y-2 mb-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs md:text-sm text-gray-600 font-semibold">Metode:</span>
                    <span class="text-sm md:text-base text-gray-800 font-medium">{{ $order->payment->method == 'cash' ? 'Cash (COD)' : 'Transfer Bank' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs md:text-sm text-gray-600 font-semibold">Status:</span>
                    <span class="px-2 md:px-3 py-1 rounded-full text-xs md:text-sm font-semibold {{ $order->payment->status == 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($order->payment->status) }}
                    </span>
                </div>
            </div>

            @if($order->payment->method == 'transfer')
                @if($order->payment->proof_of_transfer)
                    <div class="mb-4">
                        <p class="text-xs md:text-sm text-gray-600 font-semibold mb-2">Bukti Transfer:</p>
                        <a href="{{ asset('storage/' . $order->payment->proof_of_transfer) }}" target="_blank">
                            <img src="{{ asset('storage/' . $order->payment->proof_of_transfer) }}" alt="Bukti Transfer" class="w-full rounded-lg border border-gray-300 hover:opacity-90 transition cursor-pointer">
                        </a>
                        <p class="text-xs text-gray-500 mt-1 text-center">Klik untuk memperbesar</p>
                    </div>
                @elseif($order->payment->status == 'pending')
                    <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-yellow-800 text-xs md:text-sm">
                            <span class="font-semibold">⚠️ Menunggu Bukti Transfer</span><br>
                            Customer belum mengupload bukti transfer
                        </p>
                    </div>
                @endif
            @endif

            @if($order->payment->status == 'pending')
                @php
                    $canConfirm = $order->payment->method == 'cash' || ($order->payment->method == 'transfer' && $order->payment->proof_of_transfer);
                @endphp
                <form action="/admin/orders/{{ $order->id }}/confirm-payment" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                        class="w-full font-bold h-11 md:h-12 rounded-lg transition text-sm md:text-base {{ $canConfirm ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
                        {{ !$canConfirm ? 'disabled' : '' }}>
                        {{ $canConfirm ? 'Konfirmasi Pembayaran' : 'Menunggu Bukti Transfer' }}
                    </button>
                </form>
            @endif
        </div>

        <!-- Download Invoice -->
        <div class="bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-lg transition">
            <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-3 md:mb-4">Invoice</h3>
            <button onclick="openInvoiceModal()" class="w-full bg-red-800 hover:bg-red-900 text-white font-semibold h-10 rounded-lg transition text-sm flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Lihat Invoice PDF
            </button>
        </div>
    </div>
</div>

<!-- Modal Invoice -->
<div id="invoiceModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[85vh] flex flex-col">
        <div class="flex justify-between items-center p-3 md:p-4 border-b border-gray-200">
            <h3 class="text-base md:text-lg font-bold text-gray-800">Invoice - {{ $order->order_code }}</h3>
            <button onclick="closeInvoiceModal()" class="text-gray-500 hover:text-gray-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto overflow-x-hidden">
            <iframe src="/admin/orders/{{ $order->id }}/invoice" class="w-full border-0" style="height: 900px;"></iframe>
        </div>
        <div class="p-3 md:p-4 border-t border-gray-200 flex flex-col sm:flex-row gap-2 justify-end">
            <button onclick="closeInvoiceModal()" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition text-xs md:text-sm">
                Tutup
            </button>
            <a href="/admin/orders/{{ $order->id }}/invoice/download" class="inline-flex items-center justify-center px-3 py-2 bg-red-800 text-white rounded-lg font-semibold hover:bg-red-900 transition text-xs md:text-sm">
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
