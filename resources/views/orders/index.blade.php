@extends('layouts.app')

@section('title', 'Riwayat Pesanan - Rice Berapi')

@section('content')
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Riwayat Pesanan</h1>
            <p class="text-gray-600">Lihat semua pesanan yang pernah Anda buat</p>
        </div>

        @if($orders->count() > 0)
            <div class="space-y-4 md:space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition overflow-hidden">
                        <div class="p-4 md:p-6">
                            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-4 gap-4">
                                <div class="flex-1">
                                    <p class="text-xs md:text-sm text-gray-600 mb-1">Kode Pesanan</p>
                                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $order->order_code }}</p>
                                    <p class="text-xs md:text-sm text-gray-500 mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>

                                <div>
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                                            'processing' => 'bg-blue-100 text-blue-700 border-blue-300',
                                            'ready' => 'bg-purple-100 text-purple-700 border-purple-300',
                                            'completed' => 'bg-green-100 text-green-700 border-green-300',
                                            'cancelled' => 'bg-red-100 text-red-700 border-red-300',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Menunggu',
                                            'processing' => 'Diproses',
                                            'ready' => 'Siap',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    <span class="inline-block px-3 md:px-4 py-2 rounded-full font-semibold text-xs md:text-sm border {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700 border-gray-300' }}">
                                        {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-4 mb-4">
                                <div class="flex justify-between items-center mb-2">
                                    <p class="text-lg md:text-xl font-bold text-red-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    <p class="text-sm md:text-base text-gray-600">{{ $order->orderItems->count() }} item</p>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <a href="/orders/{{ $order->id }}" class="bg-red-800 text-white px-3 py-1.5 rounded-lg font-semibold hover:bg-red-900 hover:shadow-lg transition text-xs md:text-sm">
                                    Lihat Detail
                                </a>
                                <button onclick="openInvoiceModal{{ $order->id }}()" class="bg-green-600 text-white px-3 py-1.5 rounded-lg font-semibold hover:bg-green-700 hover:shadow-lg transition inline-flex items-center text-xs md:text-sm">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Invoice
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal Invoice untuk setiap order -->
                    <div id="invoiceModal{{ $order->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
                        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[85vh] flex flex-col">
                            <div class="flex justify-between items-center p-3 md:p-4 border-b border-gray-200">
                                <h3 class="text-base md:text-lg font-bold text-gray-800">Invoice - {{ $order->order_code }}</h3>
                                <button onclick="closeInvoiceModal{{ $order->id }}()" class="text-gray-500 hover:text-gray-700 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex-1 overflow-y-auto overflow-x-hidden">
                                <iframe src="/orders/{{ $order->id }}/invoice" class="w-full border-0" style="height: 900px;"></iframe>
                            </div>
                            <div class="p-3 md:p-4 border-t border-gray-200 flex flex-col sm:flex-row gap-2 justify-end">
                                <button onclick="closeInvoiceModal{{ $order->id }}()" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition text-xs md:text-sm">
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
                    function openInvoiceModal{{ $order->id }}() {
                        const modal = document.getElementById('invoiceModal{{ $order->id }}');
                        modal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }
                    
                    function closeInvoiceModal{{ $order->id }}() {
                        const modal = document.getElementById('invoiceModal{{ $order->id }}');
                        modal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }
                    
                    document.getElementById('invoiceModal{{ $order->id }}').addEventListener('click', function(e) {
                        if (e.target === this) {
                            closeInvoiceModal{{ $order->id }}();
                        }
                    });
                    </script>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md p-8 md:p-12 text-center">
                <div class="text-6xl md:text-8xl mb-6">📦</div>
                <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Belum Ada Pesanan</h3>
                <p class="text-gray-600 mb-6 md:mb-8 text-base md:text-lg">Anda belum memiliki riwayat pesanan</p>
                <a href="/menu" class="inline-block bg-red-800 text-white font-bold py-3 md:py-4 px-6 md:px-8 rounded-lg hover:bg-red-900 hover:shadow-xl transition duration-200">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</section>
@endsection
