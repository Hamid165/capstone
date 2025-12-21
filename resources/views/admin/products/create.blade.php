@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('products.index') }}" class="inline-flex items-center text-gray-500 hover:text-emerald-600 mb-6 transition-colors">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Produk
    </a>

    <div class="bg-white rounded-xl shadow-sm p-8">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition-shadow" placeholder="Contoh: Selada Romaine Hidroponik" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price') }}" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition-shadow" placeholder="15000" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stok Awal</label>
                    <input type="number" name="stock" value="{{ old('stock') }}" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition-shadow" placeholder="100" required>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Produk</label>
                    <textarea name="description" rows="4" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition-shadow" required>{{ old('description') }}</textarea>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Produk</label>
                    <input type="file" name="image" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-emerald-50 file:text-emerald-700
                        hover:file:bg-emerald-100
                    ">
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maks: 2MB.</p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-lg font-semibold transition-all shadow-lg shadow-emerald-200">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection