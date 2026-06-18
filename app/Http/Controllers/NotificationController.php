<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Tampilkan halaman notifikasi
    public function index()
    {
        // Ambil semua notifikasi user yang login, urutkan dari yang terbaru
        $notifications = Notification::where('user_id', session('user_id'))
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    // Tandai notifikasi sebagai sudah dibaca
    public function markRead($id)
    {
        // Cari notifikasi berdasarkan ID dan user_id
        $notification = Notification::where('id', $id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        // Update status is_read menjadi true
        $notification->update(['is_read' => true]);

        return back()->with('success', 'Notifikasi ditandai sudah dibaca');
    }

    // Tandai semua notifikasi sebagai sudah dibaca
    public function markAllRead()
    {
        // Update semua notifikasi user menjadi sudah dibaca
        Notification::where('user_id', session('user_id'))
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca');
    }
}
