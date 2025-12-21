<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController; // <--- PENTING: Jangan lupa import ini!
use Illuminate\Support\Facades\Route;

// 1. Ganti Route '/' agar memanggil HomeController (Tampilan Hijau)
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Route Dashboard Admin (Arahkan ke admin.dashboard)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('products', ProductController::class);
});

// 3. Route Profile (Bawaan Breeze - Biarkan saja)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
