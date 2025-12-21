@extends('layouts.app')

@section('title', 'Katalog Produk - Dhawuh Bumi')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-6">
        
        {{-- Header --}}
        <div class="text-center mb-16" data-aos="fade-down">
            <h1 class="text-4xl lg:text-5xl font-bold font-serif text-slate-900 mb-4">Produk Segar Kami</h1>
            <div class="w-24 h-1.5 bg-[#4CAF50] mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                Pilih sayuran hidroponik terbaik yang dipanen langsung dari kebun kami. Segar, sehat, dan bebas pestisida.
            </p>
        </div>

        {{-- Search & Filter (Optional placeholder for now) --}}
        <div class="mb-12 flex justify-center" data-aos="fade-up">
            <form action="{{ route('catalog.index') }}" method="GET" class="relative w-full max-w-3xl">
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="w-full pl-12 pr-4 py-3 rounded-full border border-gray-200 focus:border-[#4CAF50] focus:ring focus:ring-emerald-200 outline-none transition-all shadow-sm"
                       placeholder="Cari sayuran...">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </form>
        </div>

        {{-- Product Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($products as $product)
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 group flex flex-col" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}">
                    {{-- Image --}}
                    <div class="relative h-64 overflow-hidden bg-gray-100">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                             <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <i class="fas fa-image text-4xl"></i>
                            </div>
                        @endif
                        
                        {{-- Badges --}}
                        <div class="absolute top-4 left-4 flex flex-col gap-2">
                            @if($product->is_best_seller)
                                <span class="bg-amber-400 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
                                    <i class="fas fa-star mr-1"></i> Terlaris
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-[#4CAF50] transition-colors line-clamp-1">{{ $product->name }}</h3>
                        
                        <div class="flex items-baseline gap-1 mb-3">
                            <span class="text-emerald-600 font-bold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-gray-500 text-sm">/ kg</span>
                        </div>

                        <p class="text-gray-500 text-sm mb-6 line-clamp-2 flex-grow">
                            {{ Str::limit($product->description, 80) }}
                        </p>

                        {{-- Action Buttons --}}
                        <div class="grid grid-cols-5 gap-3 mt-auto">
                            <form action="{{ route('cart.store') }}" method="POST" class="col-span-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full h-10 bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-100 transition-colors flex items-center justify-center border border-emerald-100" title="Tambah ke Keranjang">
                                    <i class="fas fa-shopping-basket"></i>
                                </button>
                            </form>
                            <a href="{{ route('catalog.show', $product->slug) }}" class="col-span-4 bg-[#4CAF50] text-white rounded-xl hover:bg-emerald-600 transition-colors flex items-center justify-center h-10 font-bold text-sm shadow-md shadow-emerald-200">
                                Beli
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-400 text-4xl">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Produk Tidak Ditemukan</h3>
                    <p class="text-gray-500">Maaf, kami tidak menemukan produk yang Anda cari.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-16">
            {{ $products->links() }}
        </div>

    </div>
</div>
@endsection
