@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm p-8 border border-gray-100">
    
    <div class="mb-6 pb-6 border-b border-gray-100">
        <h2 class="text-xl font-bold text-gray-800">Form Tambah Produk</h2>
        <p class="text-sm text-gray-500">Isi detail produk hidroponik Anda di bawah ini.</p>
    </div>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Nama Produk -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500"
                   placeholder="Contoh: Selada Keriting Hijau" value="{{ old('name') }}">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi & Manfaat</label>
            <textarea name="description" id="description" rows="4" required
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500"
                      placeholder="Jelaskan detail produk, rasa, dan manfaat kesehatannya...">{{ old('description') }}</textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Harga -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                    <input type="number" name="price" id="price" required min="0" step="100"
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500"
                           value="{{ old('price') }}">
                </div>
                @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Stok -->
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stok Awal <span class="text-red-500">*</span></label>
                <input type="number" name="stock" id="stock" required min="0"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500"
                       value="{{ old('stock') }}">
                @error('stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Foto Produk -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Produk</label>
            <div class="flex items-center gap-4">
                <div class="w-24 h-24 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden relative">
                    <img id="preview-image" src="#" alt="Preview" class="w-full h-full object-cover hidden">
                    <i id="placeholder-icon" class="fas fa-image text-gray-400 text-2xl"></i>
                </div>
                <div class="flex-1">
                    <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(this)"
                           class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-emerald-50 file:text-emerald-700
                                  hover:file:bg-emerald-100">
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maks: 2MB.</p>
                </div>
            </div>
             @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Best Seller Switch -->
        <div class="flex items-center justify-between bg-emerald-50 p-4 rounded-lg border border-emerald-100">
            <div>
                <h4 class="font-medium text-emerald-900">Produk Unggulan?</h4>
                <p class="text-xs text-emerald-700">Jika aktif, produk akan muncul di halaman depan dengan badge "Best Seller".</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="is_best_seller" class="sr-only peer" {{ old('is_best_seller') ? 'checked' : '' }}>
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
            </label>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex items-center gap-3 pt-4">
            <a href="{{ route('products.index') }}" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-600/20">
                <i class="fas fa-save mr-2"></i> Simpan Produk
            </button>
        </div>

    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('preview-image').classList.remove('hidden');
                document.getElementById('placeholder-icon').classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection