<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

// --- 1. HALAMAN DEPAN (FRONT END) ---
// Ini agar saat buka website, yang muncul tampilan Toko Hijau, bukan Welcome Laravel
Route::get('/', [HomeController::class, 'index'])->name('home');

// --- 2. AUTHENTICATION (LOGIN/REGISTER) ---
// Wajib ada agar bisa login. Pastikan file auth.php ada di folder routes.
// Midtrans Webhook
Route::post('/midtrans-callback', [\App\Http\Controllers\WebhookController::class, 'handler']);



// --- 1.b HALAMAN KATALOG PRODUK (Hanya Member) ---
Route::get('/tentang-kami', function () {
    return view('about.about');
})->name('about');

Route::middleware(['auth'])->group(function () {
    Route::get('/produk', [\App\Http\Controllers\CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/produk/{product:slug}', [\App\Http\Controllers\CatalogController::class, 'show'])->name('catalog.show');
    Route::get('/produk/{product:slug}/ulasan', [\App\Http\Controllers\CatalogController::class, 'reviews'])->name('catalog.reviews');
    
    // Shopping Cart
    Route::get('/keranjang', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah', [\App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
    Route::patch('/keranjang/{cartItem}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{cartItem}', [\App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout
    Route::get('/checkout/shipping', [\App\Http\Controllers\CheckoutController::class, 'shippingForm'])->name('checkout.shipping');
    Route::post('/checkout/shipping', [\App\Http\Controllers\CheckoutController::class, 'storeShipping'])->name('checkout.storeShipping');
    Route::get('/checkout/summary', [\App\Http\Controllers\CheckoutController::class, 'summary'])->name('checkout.summary');
    Route::post('/checkout/process', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');

    // Customer Order Details
    Route::post('/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/riwayat-pesanan', [\App\Http\Controllers\OrderController::class, 'indexCustomer'])->name('orders.history');
    Route::get('/pesanan/{order}', [\App\Http\Controllers\OrderController::class, 'showCustomer'])->name('customer.orders.show');
});

// --- 3. HALAMAN ADMIN (DASHBOARD & CRUD) ---
// Semua route di dalam sini dilindungi password dan role admin
Route::middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Produk (CRUD)
    Route::resource('products', ProductController::class);

    // Manajemen Pesanan (Baru)
    Route::get('orders/{order}/print', [OrderController::class, 'print'])->name('orders.print');
    Route::patch('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::resource('orders', OrderController::class);

    // Manajemen Ongkir
    Route::resource('shipping-rates', \App\Http\Controllers\ShippingRateController::class);
});

// 3. Route Profile (Bawaan Breeze - Biarkan saja)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';