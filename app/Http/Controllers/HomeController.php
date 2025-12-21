<?php

namespace App\Http\Controllers; // <--- Pastikan baris ini ada!

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 4 Produk Best Seller
        $bestSellers = Product::where('is_best_seller', true)->take(4)->get();

        // Ambil semua produk sisanya (terbaru)
        $products = Product::latest()->paginate(8);

        // Kirim data ke tampilan home
        return view('home', compact('bestSellers', 'products'));
    }
}