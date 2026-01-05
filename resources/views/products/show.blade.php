@extends('layouts.app')

@section('title', $product->name . ' - Dhawuh Bumi')

@section('content')
<div class="bg-white min-h-screen py-12">
    <div class="container mx-auto px-6 max-w-6xl">
        
        {{-- Back Button --}}
        <div class="mb-8">
            <a href="{{ route('catalog.index') }}" class="inline-flex items-center text-gray-500 hover:text-[#4CAF50] transition-colors font-medium">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        {{-- Top Section: Image & Info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
            {{-- Left: Image --}}
            <div class="bg-gray-50 rounded-3xl p-8 flex items-center justify-center relative overflow-hidden h-[400px] md:h-[500px]">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain drop-shadow-xl" data-aos="zoom-in">
                @else
                    <div class="flex flex-col items-center justify-center text-gray-300">
                        <i class="fas fa-image text-6xl mb-4"></i>
                        <span>No Image</span>
                    </div>
                @endif
            </div>

            {{-- Right: Product Info --}}
            <div class="flex flex-col justify-center" data-aos="fade-left">
                <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4 font-serif">{{ $product->name }}</h1>
                
                <div class="flex items-end gap-2 mb-2">
                    <span class="text-4xl font-bold text-[#4CAF50]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    <span class="text-xl text-gray-500 mb-1">/kg</span>
                </div>

                {{-- Short Description --}}
                <p class="text-gray-600 mb-6 leading-relaxed">
                    {{ Str::limit($product->description, 150) }}
                </p>

                <p class="text-sm text-gray-500 italic mb-8">(stok {{ $product->stock }} kg)</p>

                {{-- Short Feature List (Optional, hardcoded for consistency with image reference look) --}}
                <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-100 mb-8">
                    <ul class="space-y-2 text-sm text-emerald-800">
                        <li class="flex items-center gap-2"><i class="fas fa-leaf"></i> Bebas Pestisida Berbahaya</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check"></i> Panen Langsung dari Kebun</li>
                        <li class="flex items-center gap-2"><i class="fas fa-shipping-fast"></i> Pengiriman Cepat & Aman</li>
                    </ul>
                </div>

                {{-- Action Buttons --}}
                <form action="{{ route('cart.store') }}" method="POST" class="mb-8">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    {{-- Quantity Input --}}
                    <div class="mb-6 flex items-center gap-4">
                        <label for="quantity" class="font-bold text-gray-700">Jumlah:</label>
                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden w-32">
                            <button type="button" onclick="decrementQuantity()" class="w-10 h-10 bg-gray-50 hover:bg-gray-100 flex items-center justify-center text-gray-600 transition-colors">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-full h-10 text-center border-none focus:ring-0 appearance-none bg-white p-0" width="100%">
                            <button type="button" onclick="incrementQuantity()" class="w-10 h-10 bg-gray-50 hover:bg-gray-100 flex items-center justify-center text-gray-600 transition-colors">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit" name="action" value="add_to_cart" class="flex-1 px-8 py-4 bg-gray-600 text-white rounded-xl font-bold hover:bg-gray-700 transition-all shadow-md flex items-center justify-center gap-2 group">
                            <i class="fas fa-shopping-basket group-hover:scale-110 transition-transform"></i>
                            Tambah Ke Keranjang
                        </button>
                        <button type="submit" name="action" value="buy_now" class="flex-1 px-8 py-4 bg-[#4CAF50] text-white rounded-xl font-bold hover:bg-emerald-600 transition-all shadow-lg flex items-center justify-center gap-2 group shadow-emerald-200">
                            <i class="fas fa-check-circle group-hover:scale-110 transition-transform"></i>
                            Beli Sekarang
                        </button>
                    </div>
                </form>

                <script>
                    function incrementQuantity() {
                        const input = document.getElementById('quantity');
                        const max = parseInt(input.getAttribute('max'));
                        let value = parseInt(input.value);
                        if(value < max) {
                            input.value = value + 1;
                        }
                    }
                    function decrementQuantity() {
                        const input = document.getElementById('quantity');
                        let value = parseInt(input.value);
                        if(value > 1) {
                            input.value = value - 1;
                        }
                    }
                </script>
            </div>
        </div>

        {{-- Bottom Section Description & Reviews --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 border-t pt-12">
            
            {{-- Left: Full Description --}}
            <div class="lg:col-span-2" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-slate-900 mb-6 font-serif">Deskripsi Lengkap</h2>
                <div class="prose prose-emerald max-w-none text-gray-600 leading-relaxed mb-8">
                    {{-- Assuming description allows basic HTML or just newlines. Converting newlines to <br> if needed or just displaying --}}
                    {!! nl2br(e($product->description)) !!}
                </div>
                
                {{-- Additional Product Image in Description --}}
                @if($product->image)
                    <div class="rounded-2xl overflow-hidden shadow-sm border border-gray-100 w-64">
                         <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }} Detail" class="w-full h-auto object-cover">
                    </div>
                @endif
            </div>

            {{-- Right: Reviews --}}
            <div class="lg:col-span-1" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-slate-900 font-serif">Ulasan Pelanggan <span class="text-gray-400 text-lg">({{ $totalReviews }})</span></h3>
                </div>
                
                {{-- Average Rating --}}
                <div class="flex items-center gap-2 mb-6">
                    <div class="flex text-yellow-400 text-xl">
                         @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($averageRating))
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star text-gray-300"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="font-bold text-slate-900 text-xl">{{ number_format($averageRating, 1) }}/5</span>
                </div>

                {{-- Review List --}}
                <div class="space-y-6 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($reviews->take(5) as $review)
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold uppercase">
                                    {{ substr($review->user->name, 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 text-sm">{{ $review->user->name }}</p>
                                    <div class="flex text-yellow-400 text-xs">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star text-gray-300"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="text-[10px] text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm italic mb-3">"{{ $review->comment }}"</p>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500 italic">
                            Belum ada ulasan untuk produk ini. Jadilah yang pertama memberikan ulasan!
                        </div>
                    @endforelse

                    @if($totalReviews > 5)
                        <a href="{{ route('catalog.reviews', $product->slug) }}" class="block text-center text-[#4CAF50] font-bold text-sm hover:underline mt-4">Lihat semua ulasan ></a>
                    @endif
                </div>
            </div>

        </div>

        {{-- Related Products (Bonus) --}}
        @if($relatedProducts->count() > 0)
        <div class="mt-20 border-t pt-12">
            <h2 class="text-3xl font-bold text-slate-900 mb-8 font-serif text-center">Produk Lainnya</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <a href="{{ route('catalog.show', $related->slug) }}" class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all overflow-hidden border border-gray-100 block">
                        <div class="h-48 overflow-hidden bg-gray-100 relative">
                             <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-slate-800 mb-1 truncate">{{ $related->name }}</h4>
                            <p class="text-[#4CAF50] font-bold">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
