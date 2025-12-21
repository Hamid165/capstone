@extends('layouts.app')

@section('title', 'Riwayat Pesanan - Dhawuh Bumi')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-6 max-w-5xl">
        <h1 class="text-3xl font-bold text-slate-800 mb-8 font-serif">Riwayat Pesanan</h1>

        @if($orders->isEmpty())
            <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6 text-emerald-600 text-3xl">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-2">Belum ada pesanan</h2>
                <p class="text-gray-500 mb-8">Yuk mulai belanja sayuran segar hari ini!</p>
                <a href="{{ route('catalog.index') }}" class="inline-flex items-center px-6 py-3 bg-[#4CAF50] text-white font-bold rounded-lg hover:bg-emerald-600 transition-colors">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="p-4 border-b border-gray-50 bg-gray-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-4 text-sm">
                            <span class="font-bold text-gray-800">Order #{{ $order->id }}</span>
                            <span class="text-gray-400">|</span>
                            <span class="text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'processing' => 'bg-blue-100 text-blue-800',
                                    'shipped' => 'bg-purple-100 text-purple-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $statusLabels = [
                                    'pending' => 'Menunggu Pembayaran',
                                    'processing' => 'Sedang Diproses',
                                    'shipped' => 'Sedang Dikirim',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                ];
                                $color = $statusColors[$order->shipping_status] ?? 'bg-gray-100 text-gray-800';
                                $label = $statusLabels[$order->shipping_status] ?? ucfirst($order->shipping_status);
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $color }}">
                                {{ $label }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row gap-6 items-center">
                            {{-- Preview Item (First Item) --}}
                            <div class="flex-1 w-full">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                         @if($order->items->first() && $order->items->first()->product && $order->items->first()->product->image)
                                            <img src="{{ asset('storage/' . $order->items->first()->product->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-image"></i></div>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800">{{ $order->items->first()->product->name ?? 'Produk Dihapus' }}</h3>
                                        <p class="text-sm text-gray-500">{{ $order->items->count() > 1 ? '+ ' . ($order->items->count() - 1) . ' produk lainnya' : '1 produk' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full md:w-auto text-right">
                                <p class="text-sm text-gray-500 mb-1">Total Belanja</p>
                                <p class="font-bold text-lg text-[#4CAF50]">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>

                            <div class="w-full md:w-auto">
                                <a href="{{ route('customer.orders.show', $order->id) }}" class="block w-full text-center px-6 py-2 border border-[#4CAF50] text-[#4CAF50] font-bold rounded-lg hover:bg-emerald-50 transition-colors">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
