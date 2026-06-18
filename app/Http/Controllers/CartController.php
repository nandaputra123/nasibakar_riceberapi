<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Tampilkan halaman keranjang belanja
    public function index()
    {
        // Ambil semua item di keranjang user yang sedang login
        $cartItems = Cart::with('product')
            ->where('user_id', session('user_id'))
            ->get();

        // Hitung total harga keseluruhan
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'totalPrice'));
    }

    // Tambah produk ke keranjang
    public function add(Request $request)
    {
        // Validasi input
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Cek apakah produk ada dan stoknya cukup
        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok produk tidak mencukupi');
        }

        // Cek apakah produk sudah ada di keranjang user
        $cartItem = Cart::where('user_id', session('user_id'))
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // Jika sudah ada, update quantity
            $newQuantity = $cartItem->quantity + $request->quantity;

            // Cek apakah stok cukup untuk quantity baru
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Stok produk tidak mencukupi');
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Jika belum ada, buat item baru di keranjang
            Cart::create([
                'user_id' => session('user_id'),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    // Update quantity item di keranjang
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Ambil item keranjang berdasarkan ID
        $cartItem = Cart::where('id', $id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        // Cek apakah stok produk cukup
        if ($cartItem->product->stock < $request->quantity) {
            return back()->with('error', 'Stok produk tidak mencukupi');
        }

        // Update quantity
        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang berhasil diupdate');
    }

    // Hapus item dari keranjang
    public function remove($id)
    {
        // Hapus item keranjang berdasarkan ID
        $cartItem = Cart::where('id', $id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        $cartItem->delete();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang');
    }
}
