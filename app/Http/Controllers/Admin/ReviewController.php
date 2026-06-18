<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Tampilkan semua review
    public function index(Request $request)
    {
        // Query builder
        $query = Review::with(['user', 'product', 'order']);

        // Filter berdasarkan rating jika ada
        if ($request->has('rating') && $request->rating != '') {
            $query->where('rating', $request->rating);
        }

        // Ambil reviews dengan pagination, urutkan dari terbaru
        $reviews = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }
}
