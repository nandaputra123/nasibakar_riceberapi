<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    // Tampilkan halaman checkout
    public function checkout()
    {
        // Ambil semua item di keranjang user
        $cartItems = Cart::with('product')
            ->where('user_id', session('user_id'))
            ->get();

        // Jika keranjang kosong, redirect ke keranjang
        if ($cartItems->isEmpty()) {
            return redirect('/cart')->with('error', 'Keranjang Anda kosong');
        }

        // Hitung total harga
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Ambil data user untuk prepopulate form
        $user = User::find(session('user_id'));

        return view('orders.checkout', compact('cartItems', 'totalPrice', 'user'));
    }

    // Proses pembuatan order (checkout)
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|in:cash,transfer',
            'proof_of_transfer' => 'required_if:payment_method,transfer|image|mimes:jpeg,jpg,png|max:2048',
            'note' => 'nullable|string',
        ], [
            'proof_of_transfer.required_if' => 'Bukti transfer harus diupload',
            'proof_of_transfer.image' => 'File harus berupa gambar',
            'proof_of_transfer.mimes' => 'Format file harus jpeg, jpg, atau png',
            'proof_of_transfer.max' => 'Ukuran file maksimal 2MB',
        ]);

        // Ambil semua item di keranjang
        $cartItems = Cart::with('product')
            ->where('user_id', session('user_id'))
            ->get();

        // Validasi keranjang tidak kosong
        if ($cartItems->isEmpty()) {
            return redirect('/cart')->with('error', 'Keranjang Anda kosong');
        }

        // Mulai database transaction untuk keamanan data
        DB::beginTransaction();

        try {
            // Validasi stok setiap produk
            foreach ($cartItems as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception("Stok {$item->product->name} tidak mencukupi");
                }
            }

            // Generate order code: RB-YYYYMMDD-XXXX
            $orderCode = 'RB-' . date('Ymd') . '-' . str_pad(Order::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

            // Hitung total price
            $totalPrice = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            $proofPath = null;
            if ($request->payment_method === 'transfer' && $request->hasFile('proof_of_transfer')) {
                $file = $request->file('proof_of_transfer');
                $filename = 'proof_' . $orderCode . '_' . time() . '.' . $file->getClientOriginalExtension();
                $proofPath = $file->storeAs('payments', $filename, 'public');
            }

            // Buat order baru
            $order = Order::create([
                'user_id' => session('user_id'),
                'order_code' => $orderCode,
                'status' => 'pending',
                'total_price' => $totalPrice,
                'shipping_address' => $request->shipping_address,
                'phone' => $request->phone,
                'note' => $request->note,
            ]);

            // Simpan order items dan kurangi stok produk
            foreach ($cartItems as $item) {
                // Buat order item (snapshot harga dan nama produk saat ini)
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'product_name' => $item->product->name,
                ]);

                // Kurangi stok produk
                $item->product->decrement('stock', $item->quantity);
            }

            // Buat payment record
            Payment::create([
                'order_id' => $order->id,
                'method' => $request->payment_method,
                'status' => 'pending',
                'amount' => $totalPrice,
                'proof_of_transfer' => $proofPath,
            ]);

            // Kosongkan keranjang user
            Cart::where('user_id', session('user_id'))->delete();

            // Kirim notifikasi ke customer
            Notification::create([
                'user_id' => session('user_id'),
                'title' => 'Pesanan Berhasil Dibuat',
                'message' => "Pesanan Anda dengan kode {$orderCode} berhasil dibuat. Menunggu konfirmasi admin.",
                'type' => 'order',
            ]);

            // Kirim notifikasi ke semua admin
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'title' => 'Pesanan Baru',
                    'message' => "Pesanan baru {$orderCode} dari " . session('user_name'),
                    'type' => 'order',
                ]);
            }

            if ($request->payment_method === 'transfer') {
                foreach ($admins as $admin) {
                    Notification::create([
                        'user_id' => $admin->id,
                        'title' => 'Bukti Transfer Diterima',
                        'message' => "Bukti transfer untuk pesanan {$orderCode} telah diupload",
                        'type' => 'payment',
                    ]);
                }
            }

            // Commit transaction
            DB::commit();

            return redirect("/orders/{$order->id}/success")->with('success', 'Pesanan berhasil dibuat');

        } catch (\Exception $e) {
            // Rollback jika ada error
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Halaman sukses order
    public function success(int $id)
    {
        // Ambil order berdasarkan ID
        $order = Order::with(['orderItems.product', 'payment'])
            ->where('id', $id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        return view('orders.success', compact('order'));
    }

    // Tampilkan riwayat pesanan user
    public function index()
    {
        // Ambil semua pesanan user yang login
        $orders = Order::where('user_id', session('user_id'))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // Tampilkan detail pesanan
    public function show(int $id)
    {
        // Ambil order dengan relasi
        $order = Order::with(['orderItems.product', 'payment'])
            ->where('id', $id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }

    // View invoice di modal (preview)
    public function viewInvoice(int $id)
    {
        // Ambil order dengan relasi, pastikan milik user yang login
        $order = Order::with(['user', 'orderItems.product', 'payment'])
            ->where('id', $id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        return view('orders.invoice', compact('order'));
    }

    // Download invoice PDF
    public function downloadInvoice(int $id)
    {
        // Ambil order dengan relasi, pastikan milik user yang login
        $order = Order::with(['user', 'orderItems.product', 'payment'])
            ->where('id', $id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        // Generate PDF dari view invoice
        $pdf = Pdf::loadView('orders.invoice', compact('order'));
        
        // Set paper size dan orientation
        $pdf->setPaper('a4', 'portrait');

        // Download dengan nama file yang sesuai
        return $pdf->download('invoice-' . $order->order_code . '.pdf');
    }

    // Upload bukti transfer
    public function uploadProof(Request $request, int $id)
    {
        // Validasi input
        $request->validate([
            'proof_of_transfer' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'proof_of_transfer.required' => 'Bukti transfer harus diupload',
            'proof_of_transfer.image' => 'File harus berupa gambar',
            'proof_of_transfer.mimes' => 'Format file harus jpeg, jpg, atau png',
            'proof_of_transfer.max' => 'Ukuran file maksimal 2MB',
        ]);

        // Ambil order, pastikan milik user yang login
        $order = Order::with('payment')
            ->where('id', $id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        // Cek metode pembayaran harus transfer
        if ($order->payment->method !== 'transfer') {
            return back()->with('error', 'Upload bukti transfer hanya untuk metode pembayaran Transfer Bank');
        }

        // Upload file
        $file = $request->file('proof_of_transfer');
        $filename = 'proof_' . $order->order_code . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('payments', $filename, 'public');

        // Update payment record
        $order->payment->update([
            'proof_of_transfer' => $path,
        ]);

        // Kirim notifikasi ke semua admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Bukti Transfer Diterima',
                'message' => "Bukti transfer untuk pesanan {$order->order_code} telah diupload",
                'type' => 'payment',
            ]);
        }

        return back()->with('success', 'Bukti transfer berhasil diupload. Admin akan segera memverifikasi pembayaran Anda.');
    }
}
