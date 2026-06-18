@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

@section('content')
<div class="mb-6 md:mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Kelola Pesanan</h1>
</div>

<!-- Filter -->
<div class="bg-white rounded-xl shadow-md p-4 md:p-6 mb-4 md:mb-6">
    <form method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 md:gap-4">
        <select name="status" class="px-3 md:px-4 py-2 md:py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 text-sm md:text-base">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Ready</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <button type="submit" class="bg-red-800 hover:bg-red-900 text-white px-4 md:px-6 py-2 md:py-2.5 rounded-lg font-semibold hover:shadow-lg transition text-sm md:text-base">
            Filter
        </button>
        @if(request('status'))
            <a href="/admin/orders" class="bg-gray-200 text-gray-700 px-4 md:px-6 py-2 md:py-2.5 rounded-lg font-semibold hover:bg-gray-300 transition text-center text-sm md:text-base">
                Reset
            </a>
        @endif
    </form>
</div>

@if($orders->count() > 0)
    <!-- Desktop Table View -->
    <div class="hidden lg:block bg-white rounded-xl shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kode Pesanan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-bold text-gray-800">{{ $order->order_code }}</td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-800">{{ $order->user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                        </td>
                        <td class="px-6 py-4 font-bold text-red-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'processing' => 'bg-blue-100 text-blue-700',
                                    'ready' => 'bg-purple-100 text-purple-700',
                                    'completed' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="/admin/orders/{{ $order->id }}" class="text-blue-600 hover:text-blue-700 hover:bg-blue-50 p-2 rounded-lg transition" title="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <button onclick="openInvoiceModal{{ $order->id }}()" class="text-green-600 hover:text-green-700 hover:bg-green-50 p-2 rounded-lg transition" title="Lihat Invoice">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal Invoices untuk Desktop -->
        @foreach($orders as $order)
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
                        <iframe src="/admin/orders/{{ $order->id }}/invoice" class="w-full border-0" style="height: 900px;"></iframe>
                    </div>
                    <div class="p-3 md:p-4 border-t border-gray-200 flex flex-col sm:flex-row gap-2 justify-end">
                        <button onclick="closeInvoiceModal{{ $order->id }}()" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition text-xs md:text-sm">
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

    <!-- Mobile/Tablet Card View -->
    <div class="lg:hidden space-y-4">
        @foreach($orders as $order)
            <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-sm md:text-base text-gray-800 mb-1">{{ $order->order_code }}</p>
                        <p class="text-xs md:text-sm text-gray-600 truncate">{{ $order->user->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $order->user->email }}</p>
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
                    <span class="px-2 md:px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                    <div>
                        <p class="text-base md:text-lg font-bold text-red-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        <p class="text-xs md:text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="/admin/orders/{{ $order->id }}" class="text-blue-600 hover:text-blue-700 hover:bg-blue-50 p-2 rounded-lg transition" title="Detail">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                        <button onclick="openInvoiceModalMobile{{ $order->id }}()" class="text-green-600 hover:text-green-700 hover:bg-green-50 p-2 rounded-lg transition" title="Lihat Invoice">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Modal untuk mobile/tablet -->
            <div id="invoiceModalMobile{{ $order->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[85vh] flex flex-col">
                    <div class="flex justify-between items-center p-3 border-b border-gray-200">
                        <h3 class="text-sm font-bold text-gray-800">Invoice - {{ $order->order_code }}</h3>
                        <button onclick="closeInvoiceModalMobile{{ $order->id }}()" class="text-gray-500 hover:text-gray-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1 overflow-y-auto overflow-x-hidden">
                        <iframe src="/admin/orders/{{ $order->id }}/invoice" class="w-full border-0" style="height: 900px;"></iframe>
                    </div>
                    <div class="p-3 border-t border-gray-200 flex flex-col gap-2">
                        <a href="/admin/orders/{{ $order->id }}/invoice/download" class="inline-flex items-center justify-center px-3 py-2 bg-red-800 text-white rounded-lg font-semibold hover:bg-red-900 transition text-xs md:text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download PDF
                        </a>
                        <button onclick="closeInvoiceModalMobile{{ $order->id }}()" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition text-xs md:text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
            
            <script>
            function openInvoiceModalMobile{{ $order->id }}() {
                const modal = document.getElementById('invoiceModalMobile{{ $order->id }}');
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
            
            function closeInvoiceModalMobile{{ $order->id }}() {
                const modal = document.getElementById('invoiceModalMobile{{ $order->id }}');
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
            
            document.getElementById('invoiceModalMobile{{ $order->id }}').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeInvoiceModalMobile{{ $order->id }}();
                }
            });
            </script>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
@else
    <div class="bg-white rounded-xl shadow-md p-8 md:p-12 text-center">
        <div class="text-6xl md:text-8xl mb-4 md:mb-6">📦</div>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3 md:mb-4">Tidak Ada Pesanan</h3>
        <p class="text-sm md:text-base text-gray-600">Belum ada pesanan yang masuk</p>
    </div>
@endif
@endsection
