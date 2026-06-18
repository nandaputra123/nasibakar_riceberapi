<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Tampilkan halaman katalog menu dengan filter dan search
    public function index(Request $request)
    {
        // Query builder untuk produk dengan rating dan review count
        $query = Product::where('is_active', true)
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        // Filter berdasarkan kategori jika ada
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Search berdasarkan nama produk jika ada
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Ambil semua produk sesuai filter dengan pagination
        $products = $query->orderBy('name', 'asc')->paginate(12);

        // Ambil daftar kategori untuk filter dropdown
        $categories = ['ayam', 'seafood', 'vegetarian', 'original'];

        return view('products.index', compact('products', 'categories'));
    }

    // Tampilkan detail produk beserta review
    public function show($id)
    {
        // Ambil produk berdasarkan ID dengan relasi reviews dan user
        $product = Product::with(['reviews.user'])->findOrFail($id);

        // Hitung rata-rata rating
        $averageRating = $product->averageRating();

        // Hitung jumlah review
        $reviewCount = $product->reviewCount();

        // Ambil produk terkait (dari kategori yang sama, maksimal 4)
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'averageRating', 'reviewCount', 'relatedProducts'));
    }
}
