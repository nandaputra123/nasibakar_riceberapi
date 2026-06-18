<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Tampilkan dashboard admin dengan statistik
    public function index()
    {
        // Hitung total customer (user dengan role customer)
        $totalCustomers = User::where('role', 'customer')->count();

        // Hitung total produk
        $totalProducts = Product::count();

        // Hitung total pesanan
        $totalOrders = Order::count();

        // Hitung total pendapatan dari pesanan completed
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');

        // Ambil pesanan terbaru (10 pesanan terakhir)
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Ambil data pesanan per status untuk chart
        $ordersByStatus = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        // Ambil data pesanan per hari (7 hari terakhir)
        $dailyOrders = Order::where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Buat array untuk 7 hari terakhir
        $last7Days = [];
        $orderLabels = [];
        $orderData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $last7Days[$date] = 0;
            if ($i == 0) {
                $orderLabels[] = 'Hari ini';
            } elseif ($i == 1) {
                $orderLabels[] = 'Kemarin';
            } else {
                $orderLabels[] = $i . ' hari lalu';
            }
        }

        // Isi data pesanan
        foreach ($dailyOrders as $order) {
            $last7Days[$order->date] = $order->total;
        }
        $orderData = array_values($last7Days);

        // Ambil data pendapatan per hari (7 hari terakhir) - hanya completed
        $dailyRevenue = Order::where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Buat array untuk revenue 7 hari terakhir
        $last7DaysRevenue = [];
        $revenueLabels = [];
        $revenueData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $last7DaysRevenue[$date] = 0;
            if ($i == 0) {
                $revenueLabels[] = 'Hari ini';
            } elseif ($i == 1) {
                $revenueLabels[] = 'Kemarin';
            } else {
                $revenueLabels[] = $i . ' hari lalu';
            }
        }

        // Isi data revenue
        foreach ($dailyRevenue as $revenue) {
            $last7DaysRevenue[$revenue->date] = $revenue->revenue;
        }
        $revenueData = array_values($last7DaysRevenue);

        return view('admin.dashboard.index', compact(
            'totalCustomers',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'recentOrders',
            'ordersByStatus',
            'orderLabels',
            'orderData',
            'revenueLabels',
            'revenueData'
        ));
    }
}
