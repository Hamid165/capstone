@extends('layouts.app')

@section('title', 'Keranjang Belanja - Dhawuh Bumi')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-6 max-w-6xl">
        <h1 class="text-3xl font-bold text-slate-900 mb-8 font-serif">Keranjang Belanja</h1>

        @if(session('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Cart Items List --}}
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm flex flex-col md:flex-row gap-6 items-center">
                            {{-- Image --}}
                            <div class="w-full md:w-32 h-32 bg-gray-100 rounded-xl overflow-hidden shrink-0">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <i class="fas fa-image text-3xl"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- Details --}}
                            <div class="flex-grow text-center md:text-left">
                                <h3 class="font-bold text-lg text-slate-800 mb-1">{{ $item->product->name }}</h3>
                                <div class="text-emerald-600 font-bold mb-4">Rp {{ number_format($item->product->price, 0, ',', '.') }} / kg</div>
                                
                                <div class="flex items-center justify-center md:justify-start gap-4">
                                    {{-- Update Quantity Form --}}
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <label class="text-sm text-gray-500">Qty:</label>
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" 
                                               class="w-16 px-2 py-1 border border-gray-300 rounded-lg text-center text-sm focus:outline-none focus:border-[#4CAF50]"
                                               onchange="this.form.submit()">
                                    </form>

                                    {{-- Remove Button --}}
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium transition-colors" onclick="return confirm('Hapus item ini?')">
                                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Subtotal --}}
                            <div class="text-right min-w-[120px]">
                                <span class="block text-xs text-gray-500 mb-1">Subtotal</span>
                                <span class="font-bold text-xl text-slate-900">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Summary / Checkout --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl p-8 shadow-lg sticky top-24">
                        <h2 class="text-xl font-bold text-slate-800 mb-6">Ringkasan Belanja</h2>
                        
                        <div class="flex justify-between items-center mb-4 text-gray-600">
                            <span>Total Item</span>
                            <span>{{ $cartItems->sum('quantity') }} items</span>
                        </div>
                        
                        <div class="border-t border-gray-100 my-4 pt-4 flex justify-between items-center mb-8">
                            <span class="font-bold text-lg text-slate-800">Total Harga</span>
                            <span class="font-bold text-2xl text-[#4CAF50]">
                                @php
                                    $total = $cartItems->sum(function($item) {
                                        return $item->product->price * $item->quantity;
                                    });
                                @endphp
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>

                        <a href="{{ route('checkout.shipping') }}" class="block w-full text-center bg-[#4CAF50] text-white py-4 rounded-xl font-bold hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-200">
                            Checkout Sekarang
                        </a>
                        
                        <a href="{{ route('catalog.index') }}" class="block text-center mt-4 text-sm text-gray-500 hover:text-[#4CAF50]">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-24 bg-white rounded-3xl shadow-sm">
                <div class="bg-emerald-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shopping-basket text-4xl text-emerald-400"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">Keranjangmu Kosong</h2>
                <p class="text-gray-500 mb-8">Wah, belum ada sayuran segar di sini.</p>
                <a href="{{ route('catalog.index') }}" class="inline-block px-8 py-3 bg-[#4CAF50] text-white font-bold rounded-full hover:bg-emerald-600 transition-colors">
                    Mulai Belanja
                </a>
            </div>
        @endif

        {{-- Recommendations Section --}}
        <div class="mt-24 border-t border-gray-100 pt-16">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-3xl font-bold text-slate-800 font-serif">Pilihan Hemat Lainnya</h2>
                <a href="{{ route('catalog.index') }}" class="text-[#4CAF50] font-bold hover:underline flex items-center gap-2 group">
                    Lihat Semua <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($recommendations as $product)
                    <div class="bg-white rounded-3xl p-4 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.12)] transition-all duration-300 border border-gray-100 group flex flex-col h-full">
                        {{-- Clickable Area for Detail --}}
                        <a href="{{ route('catalog.show', $product->slug) }}" class="block mb-4 flex-none">
                            <div class="relative h-40 md:h-52 rounded-2xl overflow-hidden bg-gray-50">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300"><i class="fas fa-image text-3xl"></i></div>
                                @endif
                                
                                {{-- Badge Discount/New (Optional Dummy) --}}
                                {{-- <div class="absolute top-3 right-3 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full">-10%</div> --}}
                            </div>
                        </a>
                        
                        {{-- Content --}}
                        <div class="text-center flex-grow flex flex-col">
                             <a href="{{ route('catalog.show', $product->slug) }}" class="group-hover:text-[#4CAF50] transition-colors">
                                <h3 class="font-bold text-slate-800 mb-1 text-lg line-clamp-1 font-serif">{{ $product->name }}</h3>
                             </a>
                             <p class="text-gray-500 text-xs mb-3 line-clamp-2">{{ Str::limit($product->description, 50) }}</p>
                             
                             <div class="mt-auto">
                                <div class="text-emerald-600 font-bold text-xl mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full py-3 bg-emerald-50 text-emerald-700 font-bold rounded-xl hover:bg-[#4CAF50] hover:text-white transition-all transform hover:-translate-y-1 shadow-sm hover:shadow-emerald-200">
                                        <i class="fas fa-cart-plus mr-2"></i> Tambah
                                    </button>
                                </form>
                             </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
