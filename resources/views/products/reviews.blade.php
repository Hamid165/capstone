@extends('layouts.app')

@section('title', 'Ulasan ' . $product->name . ' - Dhawuh Bumi')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-6 max-w-4xl">
        
        {{-- Back Button --}}
        <div class="mb-8">
            <a href="{{ route('catalog.show', $product->slug) }}" class="inline-flex items-center text-gray-500 hover:text-[#4CAF50] transition-colors font-medium">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Produk
            </a>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-sm">
            <h1 class="text-3xl font-bold text-slate-900 mb-2 font-serif">Ulasan Pelanggan</h1>
            <p class="text-gray-500 mb-8">untuk <span class="font-bold text-[#4CAF50]">{{ $product->name }}</span></p>

            {{-- Summary --}}
            <div class="flex items-center gap-4 mb-10 p-6 bg-emerald-50 rounded-2xl border border-emerald-100">
                <div class="text-5xl font-bold text-slate-800">5.0</div>
                <div>
                     <div class="flex text-yellow-400 text-xl mb-1">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-sm text-gray-600">Berdasarkan 25 ulasan</p>
                </div>
            </div>

            {{-- Review List --}}
            <div class="space-y-8">
                @foreach($reviews as $review)
                    <div class="border-b border-gray-100 pb-8 last:border-0 last:pb-0">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-lg shrink-0">
                                {{ $review['initial'] }}
                            </div>
                            <div class="flex-grow">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-bold text-slate-900">{{ $review['user'] }}</h4>
                                        <div class="flex text-yellow-400 text-xs mt-1">
                                            @for($i=0; $i<$review['rating']; $i++) <i class="fas fa-star"></i> @endfor
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-400">{{ $review['date'] }}</span>
                                </div>
                                <p class="text-gray-600 leading-relaxed">{{ $review['content'] }}</p>
                                
                                @if($review['image'])
                                    <div class="mt-4 w-24 h-24 rounded-lg overflow-hidden bg-gray-100">
                                        <img src="{{ $review['image'] }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12 pt-8 border-t border-gray-100">
                {{ $reviews->links() }}
            </div>
            
        </div>

    </div>
</div>
@endsection
