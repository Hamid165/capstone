@extends('layouts.app')

@section('title', 'Pengiriman - Checkout')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-6 max-w-4xl">
        {{-- Progress Steps --}}
        <div class="flex items-center justify-center mb-10">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-[#4CAF50] text-white rounded-full flex items-center justify-center font-bold shadow-lg shadow-emerald-200 z-10">1</div>
                <div class="ml-3 font-bold text-slate-800">Pengiriman</div>
            </div>
            <div class="w-20 h-1 bg-gray-200 mx-4 rounded-full"></div>
            <div class="flex items-center opacity-50">
                <div class="w-10 h-10 bg-white border-2 border-gray-200 text-gray-400 rounded-full flex items-center justify-center font-bold">2</div>
                <div class="ml-3 font-bold text-gray-500">Pembayaran</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Form Section --}}
            <div class="md:col-span-2">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-[#4CAF50]"></i> Alamat Pengiriman
                    </h2>

                    <form action="{{ route('checkout.storeShipping') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-6">
                            {{-- Name --}}
                            <div>
                                <label class="block font-bold text-sm text-slate-700 mb-2">Nama Penerima</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full border-gray-300 rounded-xl focus:border-[#4CAF50] focus:ring focus:ring-[#4CAF50]/20 py-3 px-4" required>
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label class="block font-bold text-sm text-slate-700 mb-2">Nomor WhatsApp / Telepon</label>
                                <input type="text" name="phone" value="{{ Auth::user()->phone ?? '' }}" class="w-full border-gray-300 rounded-xl focus:border-[#4CAF50] focus:ring focus:ring-[#4CAF50]/20 py-3 px-4" required placeholder="08xxxxxxxxxx">
                            </div>

                            {{-- Regency Dropdown --}}
                            <div>
                                <label class="block font-bold text-sm text-slate-700 mb-2">Kabupaten / Kota</label>
                                <div class="relative">
                                    <select name="shipping_rate_id" class="w-full border-gray-300 rounded-xl focus:border-[#4CAF50] focus:ring focus:ring-[#4CAF50]/20 py-3 px-4 appearance-none bg-white" required>
                                        <option value="" disabled selected>Pilih Kabupaten Tujuan</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}">
                                                {{ $city->destination_city }} - Rp {{ number_format($city->price, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">*Ongkir dihitung berdasarkan kabupaten tujuan.</p>
                            </div>

                            {{-- Full Address --}}
                            <div>
                                <label class="block font-bold text-sm text-slate-700 mb-2">Alamat Lengkap</label>
                                <textarea name="shipping_address" rows="3" class="w-full border-gray-300 rounded-xl focus:border-[#4CAF50] focus:ring focus:ring-[#4CAF50]/20 py-3 px-4" required placeholder="Jl. Mawar No. 12, RT 01/RW 02, Kec. Sumpyuh, Desa Kebokura...">{{ Auth::user()->address ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="mt-8">
                            <button type="submit" class="w-full bg-[#4CAF50] text-white font-bold py-4 rounded-xl hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-200 flex items-center justify-center gap-2">
                                Lanjut ke Pembayaran <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Cart Summary (Mini) --}}
            <div class="md:col-span-1">
                <div class="bg-gray-50 rounded-3xl p-6 border border-gray-200 sticky top-24">
                    <h3 class="font-bold text-slate-800 mb-4">Ringkasan Pesanan</h3>
                    <div class="space-y-3 mb-6 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cartItems as $item)
                            <div class="flex gap-3">
                                <div class="w-16 h-16 bg-white rounded-lg overflow-hidden shrink-0 border border-gray-100">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-300"><i class="fas fa-image"></i></div>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-700 line-clamp-1">{{ $item->product->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t border-gray-200 pt-4 flex justify-between items-center">
                        <span class="text-sm font-bold text-gray-600">Total Belanja</span>
                        <span class="font-bold text-slate-800">
                            Rp {{ number_format($cartItems->sum(fn($i) => $i->product->price * $i->quantity), 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
