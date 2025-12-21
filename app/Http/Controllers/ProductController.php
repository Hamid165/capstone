<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; 

class ProductController extends Controller
{
    // 1. Menampilkan Daftar Produk
    public function index(Request $request)
    {
        $query = Product::query();

        // Jika ada input 'search' dari form
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Ambil data (paginate tetap jalan)
        $products = $query->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    // 2. Menampilkan Form Tambah Produk
    public function create()
    {
        return view('admin.products.create');
    }


    // 3. Menyimpan Produk ke Database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Buat Slug otomatis
        $data['slug'] = Str::slug($request->name);

        // Handle Checkbox (Jika tidak dicentang, nilainya tidak dikirim form, jadi default false)
        $data['is_best_seller'] = $request->has('is_best_seller');

        // Upload Gambar jika ada
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    // 4. Menampilkan Form Edit
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // 5. Update Produk
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        // Handle Checkbox
        $data['is_best_seller'] = $request->has('is_best_seller');

        // Cek jika ada gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate');
    }

    // 6. Hapus Produk
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk dihapus');
    }
}