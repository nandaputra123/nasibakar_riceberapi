<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

// ========== ROUTES PUBLIK ==========

// Landing page
Route::get('/', [HomeController::class, 'index']);

// ========== ROUTES AUTENTIKASI ==========

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Register
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', [AuthController::class, 'logout']);

// ========== ROUTES CUSTOMER (middleware: auth.customer) ==========

Route::middleware('auth.customer')->group(function () {
    
    // Katalog menu dan detail produk
    Route::get('/menu', [ProductController::class, 'index']);
    Route::get('/menu/{id}', [ProductController::class, 'show']);
    
    // Keranjang belanja
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::patch('/cart/{id}', [CartController::class, 'update']);
    Route::delete('/cart/{id}', [CartController::class, 'remove']);

    // Checkout dan pesanan
    Route::get('/checkout', [OrderController::class, 'checkout']);
    Route::post('/checkout', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::get('/orders/{id}/success', [OrderController::class, 'success']);
    Route::get('/orders/{id}/invoice', [OrderController::class, 'viewInvoice']);
    Route::get('/orders/{id}/invoice/download', [OrderController::class, 'downloadInvoice']);
    Route::post('/orders/{id}/upload-proof', [OrderController::class, 'uploadProof']);

    // Notifikasi
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markRead']);
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllRead']);

    // Review
    Route::get('/reviews', [ReviewController::class, 'index']);
    Route::get('/reviews/create/{orderId}/{productId}', [ReviewController::class, 'create']);
    Route::post('/reviews', [ReviewController::class, 'store']);
});

// ========== ROUTES ADMIN (middleware: auth.admin, prefix: /admin) ==========

Route::prefix('admin')->middleware('auth.admin')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // CRUD Produk (Resource)
    Route::get('/products', [AdminProductController::class, 'index']);
    Route::get('/products/create', [AdminProductController::class, 'create']);
    Route::post('/products', [AdminProductController::class, 'store']);
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit']);
    Route::patch('/products/{id}', [AdminProductController::class, 'update']);
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy']);

    // Kelola pesanan
    Route::get('/orders', [AdminOrderController::class, 'index']);
    Route::get('/orders/{id}', [AdminOrderController::class, 'show']);
    Route::patch('/orders/{id}/status', [AdminOrderController::class, 'updateStatus']);
    Route::patch('/orders/{id}/confirm-payment', [AdminOrderController::class, 'confirmPayment']);
    Route::get('/orders/{id}/invoice', [AdminOrderController::class, 'viewInvoice']);
    Route::get('/orders/{id}/invoice/download', [AdminOrderController::class, 'downloadInvoice']);

    // Lihat reviews
    Route::get('/reviews', [AdminReviewController::class, 'index']);
});
