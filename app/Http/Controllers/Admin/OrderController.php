<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Notification;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    // Tampilkan daftar semua pesanan
    public function index(Request $request)
    {
        // Query builder
        $query = Order::with('user');

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Ambil pesanan dengan pagination, urutkan dari terbaru
        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    // Tampilkan detail pesanan
    public function show($id)
    {
        // Ambil order dengan relasi
        $order = Order::with(['user', 'orderItems.product', 'payment'])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    // Update status pesanan
    public function updateStatus(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'status' => 'required|in:pending,processing,ready,completed,cancelled',
        ]);

        // Ambil order
        $order = Order::findOrFail($id);
        $oldStatus = $order->status;

        // Update status
        $order->update(['status' => $request->status]);

        // Siapkan pesan notifikasi berdasarkan status baru
        $notificationMessages = [
            'processing' => "Pesanan {$order->order_code} sedang dimasak. Mohon menunggu.",
            'ready' => "Pesanan {$order->order_code} siap dikirim. Segera sampai ke tujuan!",
            'completed' => "Pesanan {$order->order_code} selesai. Selamat menikmati! Jangan lupa berikan review.",
            'cancelled' => "Pesanan {$order->order_code} dibatalkan. Silakan hubungi admin untuk info lebih lanjut.",
        ];

        // Kirim notifikasi ke customer jika status berubah
        if ($oldStatus != $request->status && isset($notificationMessages[$request->status])) {
            Notification::create([
                'user_id' => $order->user_id,
                'title' => 'Update Status Pesanan',
                'message' => $notificationMessages[$request->status],
                'type' => 'order',
            ]);
        }

        return back()->with('success', 'Status pesanan berhasil diupdate');
    }

    // Konfirmasi pembayaran
    public function confirmPayment(Request $request, $id)
    {
        // Ambil order dengan payment
        $order = Order::with('payment')->findOrFail($id);

        // Cek apakah payment ada
        if (!$order->payment) {
            return back()->with('error', 'Data pembayaran tidak ditemukan');
        }

        // Update status payment menjadi confirmed
        $order->payment->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        // Kirim notifikasi ke customer
        Notification::create([
            'user_id' => $order->user_id,
            'title' => 'Pembayaran Dikonfirmasi',
            'message' => "Pembayaran untuk pesanan {$order->order_code} sudah dikonfirmasi. Pesanan Anda akan segera diproses.",
            'type' => 'payment',
        ]);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi');
    }

    // View invoice di modal (preview)
    public function viewInvoice($id)
    {
        // Ambil order dengan relasi
        $order = Order::with(['user', 'orderItems.product', 'payment'])->findOrFail($id);

        return view('orders.invoice', compact('order'));
    }

    // Download invoice PDF (untuk admin)
    public function downloadInvoice($id)
    {
        // Ambil order dengan relasi
        $order = Order::with(['user', 'orderItems.product', 'payment'])->findOrFail($id);

        // Generate PDF dari view invoice
        $pdf = Pdf::loadView('orders.invoice', compact('order'));
        
        // Set paper size dan orientation
        $pdf->setPaper('a4', 'portrait');

        // Download dengan nama file yang sesuai
        return $pdf->download('invoice-' . $order->order_code . '.pdf');
    }
}
