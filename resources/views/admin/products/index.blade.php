@extends('layouts.admin')

@section('title', 'Daftar Produk')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 flex flex-col md:flex-row justify-between items-center border-b border-gray-100 gap-4">
    <h2 class="text-xl font-bold text-gray-800">Semua Produk</h2>
    
    <div class="flex items-center gap-2">
        <form action="{{ route('products.index') }}" method="GET" class="relative">
            <input type="text" name="search" value="{{ request('search') }}" 
                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm" 
                   placeholder="Cari produk...">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </form>

        <a href="{{ route('products.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2 text-sm">
            <i class="fas fa-plus"></i> Tambah
        </a>
    </div>
</div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-emerald-50 text-emerald-800 text-sm uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Gambar</th>
                    <th class="px-6 py-4 font-semibold">Nama Produk</th>
                    <th class="px-6 py-4 font-semibold">Harga</th>
                    <th class="px-6 py-4 font-semibold">Stok</th>
                    <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                        @else
                            <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800">{{ $product->name }}</div>
                        @if($product->is_best_seller)
                            <span class="inline-block bg-yellow-100 text-yellow-700 text-xs px-2 py-0.5 rounded-full mt-1">Best Seller</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-emerald-600 font-semibold">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $product->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $product->stock }} Pcs
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('products.edit', $product->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition-colors" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-50 text-red-600 rounded hover:bg-red-100 transition-colors" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-box-open text-4xl mb-3 block"></i>
                        Belum ada produk yang ditambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t border-gray-100">
        {{ $products->links() }}
    </div>
</div>
@endsection