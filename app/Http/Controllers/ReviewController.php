<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Tampilkan daftar produk yang bisa direview
    public function index()
    {
        // Ambil semua order completed dari user
        $completedOrders = Order::where('user_id', session('user_id'))
            ->where('status', 'completed')
            ->with(['orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Kumpulkan produk yang bisa direview
        $reviewableProducts = [];
        
        foreach ($completedOrders as $order) {
            foreach ($order->orderItems as $item) {
                if ($item->product) {
                    // Cek apakah sudah direview
                    $reviewed = Review::where('user_id', session('user_id'))
                        ->where('product_id', $item->product_id)
                        ->where('order_id', $order->id)
                        ->exists();

                    if (!$reviewed) {
                        $reviewableProducts[] = [
                            'order' => $order,
                            'product' => $item->product,
                            'order_item' => $item,
                        ];
                    }
                }
            }
        }

        return view('reviews.index', compact('reviewableProducts'));
    }

    // Tampilkan form review produk
    public function create($orderId, $productId)
    {
        // Ambil order dan validasi bahwa order milik user dan statusnya completed
        $order = Order::where('id', $orderId)
            ->where('user_id', session('user_id'))
            ->where('status', 'completed')
            ->firstOrFail();

        // Ambil produk
        $product = Product::findOrFail($productId);

        // Cek apakah produk ada di order items
        $orderItem = $order->orderItems()->where('product_id', $productId)->firstOrFail();

        // Cek apakah user sudah pernah review produk ini di order ini
        $existingReview = Review::where('user_id', session('user_id'))
            ->where('product_id', $productId)
            ->where('order_id', $orderId)
            ->first();

        if ($existingReview) {
            return redirect('/orders/' . $orderId)->with('error', 'Anda sudah memberikan review untuk produk ini');
        }

        return view('reviews.create', compact('order', 'product'));
    }

    // Simpan review
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        // Validasi order milik user dan statusnya completed
        $order = Order::where('id', $request->order_id)
            ->where('user_id', session('user_id'))
            ->where('status', 'completed')
            ->firstOrFail();

        // Cek apakah sudah pernah review
        $existingReview = Review::where('user_id', session('user_id'))
            ->where('product_id', $request->product_id)
            ->where('order_id', $request->order_id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan review untuk produk ini');
        }

        // Buat review baru
        Review::create([
            'user_id' => session('user_id'),
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect('/orders/' . $request->order_id)->with('success', 'Terima kasih atas review Anda!');
    }
}
