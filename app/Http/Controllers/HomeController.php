<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Tampilkan halaman landing page
    public function index()
    {
        // Ambil produk unggulan (8 produk pertama yang aktif) dengan rating
        $featuredProducts = Product::where('is_active', true)
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Ambil review untuk testimoni (rating tinggi)
        $testimonials = Review::with(['user', 'product'])
            ->where('rating', '>=', 4)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home.index', compact('featuredProducts', 'testimonials'));
    }
}
