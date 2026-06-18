<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Tampilkan daftar semua produk
    public function index()
    {
        // Ambil semua produk dengan pagination
        $products = Product::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    // Tampilkan form tambah produk baru
    public function create()
    {
        $categories = ['ayam', 'seafood', 'vegetarian', 'original'];
        return view('admin.products.create', compact('categories'));
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|in:ayam,seafood,vegetarian,original',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,avif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        // Siapkan data produk
        $data = $request->except('image');
        $data['is_active'] = $request->has('is_active') ? true : false;

        // Handle upload gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        // Buat produk baru
        Product::create($data);

        return redirect('/admin/products')->with('success', 'Produk berhasil ditambahkan');
    }

    // Tampilkan form edit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = ['ayam', 'seafood', 'vegetarian', 'original'];
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Update produk
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|in:ayam,seafood,vegetarian,original',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,avif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        // Ambil produk
        $product = Product::findOrFail($id);

        // Siapkan data update
        $data = $request->except('image');
        $data['is_active'] = $request->has('is_active') ? true : false;

        // Handle upload gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // Upload gambar baru
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        // Update produk
        $product->update($data);

        return redirect('/admin/products')->with('success', 'Produk berhasil diupdate');
    }

    // Hapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar jika ada
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Hapus produk
        $product->delete();

        return redirect('/admin/products')->with('success', 'Produk berhasil dihapus');
    }
}
