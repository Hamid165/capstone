@extends('layouts.app')

@section('title', 'Ringkasan & Pembayaran - Checkout')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-6 max-w-4xl">
        {{-- Progress Steps --}}
        <div class="flex items-center justify-center mb-10">
            <div class="flex items-center opacity-50">
                <div class="w-10 h-10 bg-white border-2 border-gray-200 text-gray-400 rounded-full flex items-center justify-center font-bold">1</div>
                <div class="ml-3 font-bold text-gray-500">Pengiriman</div>
            </div>
            <div class="w-20 h-1 bg-[#4CAF50] mx-4 rounded-full"></div>
            <div class="flex items-center">
                <div class="w-10 h-10 bg-[#4CAF50] text-white rounded-full flex items-center justify-center font-bold shadow-lg shadow-emerald-200 z-10">2</div>
                <div class="ml-3 font-bold text-slate-800">Pembayaran</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Detail Info --}}
            <div class="md:col-span-2 space-y-6">
                {{-- Address Info --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-shipping-fast text-[#4CAF50]"></i> Informasi Pengiriman
                        </h3>
                        <a href="{{ route('checkout.shipping') }}" class="text-xs font-bold text-emerald-600 hover:underline">Ubah</a>
                    </div>
                    <div class="text-sm text-gray-600 space-y-1">
                        <div class="font-bold text-slate-800">{{ $checkoutData['name'] }} ({{ $checkoutData['phone'] }})</div>
                        <div>{{ $checkoutData['shipping_address'] }}</div>
                        <div>{{ $shippingRate->destination_city }}</div>
                    </div>
                </div>

                {{-- Items --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-shopping-basket text-[#4CAF50]"></i> Daftar Barang
                    </h3>
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                             <div class="flex items-center justify-between border-b border-gray-50 last:border-0 pb-4 last:pb-0">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-gray-100 rounded-xl overflow-hidden">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800">{{ $item->product->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                                <div class="font-bold text-slate-800">
                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </div>
                             </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Cost Summary --}}
            <div class="md:col-span-1">
                <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-100 sticky top-24">
                    <h3 class="font-bold text-slate-800 mb-6">Rincian Biaya</h3>
                    
                    <div class="space-y-3 mb-6 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Total Harga Barang</span>
                            <span class="font-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Biaya Pengiriman</span>
                            <span class="font-bold">Rp {{ number_format($shippingRate->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-dashed border-gray-200 my-2"></div>
                        <div class="flex justify-between text-lg font-bold text-slate-900">
                            <span>Total Tagihan</span>
                            <span class="text-[#4CAF50]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-[#4CAF50] text-white py-4 rounded-xl font-bold hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-200 mb-4">
                            Bayar Sekarang
                        </button>
                    </form>
                    
                    <p class="text-xs text-center text-gray-400">
                        Dengan mengklik tombol di atas, Anda menyetujui Syarat & Ketentuan kami.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
