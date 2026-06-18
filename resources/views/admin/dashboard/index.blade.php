@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Welcome Section -->
<div class="mb-6 md:mb-8">
    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-2">Dashboard Admin</h1>
    <p class="text-sm md:text-base text-gray-600">Selamat datang kembali, {{ session('user_name') }}! 👋</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
    <!-- Total Customers -->
    <div class="bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-xs md:text-sm mb-1">Total Customer</p>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $totalCustomers }}</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Products -->
    <div class="bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-xs md:text-sm mb-1">Total Produk</p>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $totalProducts }}</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-xs md:text-sm mb-1">Total Pesanan</p>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $totalOrders }}</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-xs md:text-sm mb-1">Total Pendapatan</p>
                <p class="text-lg md:text-2xl font-bold text-red-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6 md:mb-8">
    <!-- Daily Orders Chart -->
    <div class="bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-lg transition-shadow duration-300">
        <h2 class="text-lg md:text-xl lg:text-2xl font-bold text-gray-800 mb-4 md:mb-6">Jumlah Pesanan (7 Hari Terakhir)</h2>
        <div class="relative h-64 md:h-80">
            <canvas id="ordersChart"></canvas>
        </div>
    </div>

    <!-- Daily Revenue Chart -->
    <div class="bg-white rounded-xl shadow-md p-4 md:p-6 hover:shadow-lg transition-shadow duration-300">
        <h2 class="text-lg md:text-xl lg:text-2xl font-bold text-gray-800 mb-4 md:mb-6">Pendapatan (7 Hari Terakhir)</h2>
        <div class="relative h-64 md:h-80">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
    <!-- Recent Orders -->
    <div class="bg-white rounded-xl shadow-md p-4 md:p-6">
        <h2 class="text-lg md:text-xl lg:text-2xl font-bold text-gray-800 mb-4 md:mb-6">Pesanan Terbaru</h2>
        <div class="space-y-3 md:space-y-4">
            @foreach($recentOrders as $order)
                <a href="/admin/orders/{{ $order->id }}" class="block hover:bg-gray-50 -mx-2 px-2 py-2 md:py-3 rounded-lg transition">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-sm md:text-base text-gray-800 truncate">{{ $order->order_code }}</p>
                            <p class="text-xs md:text-sm text-gray-600 truncate">{{ $order->user->name }}</p>
                        </div>
                        <div class="flex items-center justify-between sm:justify-end sm:text-right gap-3 sm:gap-4">
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
                            <p class="text-xs md:text-sm text-gray-600 font-semibold whitespace-nowrap">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <a href="/admin/orders" class="block mt-4 md:mt-6 text-center text-red-800 hover:text-red-900 font-semibold text-sm md:text-base transition">
            Lihat Semua Pesanan →
        </a>
    </div>

    <!-- Recent Activity / Summary -->
    <div class="bg-white rounded-xl shadow-md p-4 md:p-6">
        <h2 class="text-lg md:text-xl lg:text-2xl font-bold text-gray-800 mb-4 md:mb-6">Statistik Status Pesanan</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-4">
            @php
                $statusInfo = [
                    'pending' => ['label' => 'Pending', 'color' => 'yellow', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                    'processing' => ['label' => 'Diproses', 'color' => 'blue', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
                    'ready' => ['label' => 'Siap', 'color' => 'purple', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    'completed' => ['label' => 'Selesai', 'color' => 'green', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    'cancelled' => ['label' => 'Batal', 'color' => 'red', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ];
            @endphp
            @foreach($statusInfo as $key => $info)
                <div class="bg-{{ $info['color'] }}-50 rounded-lg p-3 md:p-4 hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center justify-center mb-2">
                        <div class="w-8 h-8 md:w-10 md:h-10 bg-{{ $info['color'] }}-100 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4 md:w-5 md:h-5 text-{{ $info['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $info['icon'] }}"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs md:text-sm text-{{ $info['color'] }}-600 font-medium text-center mb-1">{{ $info['label'] }}</p>
                    <p class="text-lg md:text-2xl font-bold text-{{ $info['color'] }}-700 text-center">{{ $ordersByStatus[$key] ?? 0 }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Daily Orders Chart (Line Chart)
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ordersCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($orderLabels) !!},
            datasets: [{
                label: 'Jumlah Pesanan',
                data: {!! json_encode($orderData) !!},
                fill: true,
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 3,
                tension: 0.4,
                pointBackgroundColor: 'rgb(59, 130, 246)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    borderColor: 'rgba(255, 255, 255, 0.2)',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            return 'Pesanan: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Daily Revenue Chart (Bar Chart)
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($revenueLabels) !!},
            datasets: [{
                label: 'Pendapatan',
                data: {!! json_encode($revenueData) !!},
                backgroundColor: 'rgba(153, 27, 27, 0.8)',
                borderColor: 'rgb(153, 27, 27)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    borderColor: 'rgba(255, 255, 255, 0.2)',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000) + 'k';
                        },
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection
