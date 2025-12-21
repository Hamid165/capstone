@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-slate-800 font-serif">Detail Pesanan</h1>
            <a href="{{ route('home') }}" class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-lg font-bold text-sm transition-colors">
                <i class="fas fa-home"></i> Kembali ke Beranda
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Order Info --}}
            <div class="md:col-span-2 space-y-6">
                {{-- Status & ID --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex justify-between items-center">
                    <div>
                        <div class="text-xs text-gray-500 uppercase font-bold tracking-wider">Order ID</div>
                        <div class="font-bold text-xl text-slate-800">#{{ $order->id }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Status</div>
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                                'shipped' => 'bg-purple-100 text-purple-700 border-purple-200',
                                'completed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                            ];
                            $statusLabels = [
                                'pending' => 'Menunggu Pembayaran',
                                'processing' => 'Sedang Diproses',
                                'shipped' => 'Dalam Pengiriman',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ];
                            $colorInfo = $statusColors[$order->shipping_status] ?? 'bg-gray-100 text-gray-700';
                            $labelInfo = $statusLabels[$order->shipping_status] ?? $order->shipping_status;
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $colorInfo }}">
                            {{ $labelInfo }}
                        </span>
                    </div>
                </div>

                {{-- Items --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-shopping-bag text-[#4CAF50]"></i> Barang Pesanan
                    </h3>
                    <div class="divide-y divide-gray-50">
                        @foreach($order->items as $item)
                            <div class="py-4 flex gap-4 first:pt-0 last:pb-0">
                                <div class="w-16 h-16 bg-gray-100 rounded-xl overflow-hidden shrink-0">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300"><i class="fas fa-image"></i></div>
                                    @endif
                                </div>
                                <div class="flex-grow">
                                    <div class="font-bold text-slate-800">{{ $item->product->name ?? 'Produk Dihapus' }}</div>
                                    <div class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-slate-800 mb-1">
                                        Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                    </div>
                                    @if($order->shipping_status == 'completed' || $order->payment_status == 'paid')
                                        <div x-data="{ open: false }">
                                            <button @click="open = true" class="text-xs font-bold text-[#4CAF50] border border-[#4CAF50] px-3 py-1 rounded-full hover:bg-[#4CAF50] hover:text-white transition-colors">
                                                <i class="fas fa-star mr-1"></i> Beri Ulasan
                                            </button>

                                            {{-- Review Modal --}}
                                            <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak>
                                                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 transform transition-all" @click.away="open = false">
                                                    <div class="flex justify-between items-center mb-6">
                                                        <h3 class="text-lg font-bold text-slate-800">Ulasan Produk</h3>
                                                        <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>

                                                    <div class="flex items-center gap-4 mb-6 bg-gray-50 p-4 rounded-xl">
                                                        <div class="w-12 h-12 bg-white rounded-lg overflow-hidden border border-gray-100">
                                                            @if($item->product && $item->product->image)
                                                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <p class="font-bold text-slate-800 text-sm">{{ $item->product->name }}</p>
                                                            <p class="text-xs text-gray-500">Bagaimana kualitas produk ini?</p>
                                                        </div>
                                                    </div>

                                                    <form action="{{ route('reviews.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                                                        <div class="mb-6 text-center">
                                                            <label class="block text-sm font-bold text-gray-700 mb-2">Berikan Bintang</label>
                                                            <div class="flex justify-center gap-2 text-3xl text-gray-300" x-data="{ rating: 0 }">
                                                                <input type="hidden" name="rating" :value="rating">
                                                                <template x-for="i in 5">
                                                                    <button type="button" @click="rating = i" class="focus:outline-none transition-colors" :class="{'text-yellow-400': i <= rating, 'text-gray-300': i > rating}">
                                                                        <i class="fas fa-star"></i>
                                                                    </button>
                                                                </template>
                                                            </div>
                                                        </div>

                                                        <div class="mb-6">
                                                            <label class="block text-sm font-bold text-gray-700 mb-2">Komentar Anda</label>
                                                            <textarea name="comment" rows="3" class="w-full border-gray-300 rounded-xl focus:ring-[#4CAF50] focus:border-[#4CAF50] text-sm" placeholder="Ceritakan pengalaman Anda..."></textarea>
                                                        </div>

                                                        <button type="submit" class="w-full bg-[#4CAF50] text-white font-bold py-3 rounded-xl hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-200">
                                                            Kirim Ulasan
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Shipping Info --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-shipping-fast text-[#4CAF50]"></i> Info Pengiriman
                    </h3>
                    <div class="text-sm text-gray-600">
                         <p class="font-bold text-slate-800 mb-1">Alamat Tujuan</p>
                         <p>{{ $order->shipping_address_detail }}</p>
                         
                    <div class="text-sm text-gray-600">
                         <p class="font-bold text-slate-800 mb-1">Alamat Tujuan</p>
                         <p>{{ $order->shipping_address_detail }}</p>
                    </div>
                </div>
            </div>

            {{-- Payment Action --}}
            <div class="md:col-span-1">
                <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-100 sticky top-24">
                     <h3 class="font-bold text-slate-800 mb-6">Tagihan</h3>
                     
                     <div class="space-y-3 mb-6 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal Barang</span>
                            <span class="font-bold">Rp {{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Ongkos Kirim</span>
                            {{-- Calculate shipping cost (Total - Items) --}}
                            @php
                                $subtotal = $order->items->sum(fn($i) => $i->price * $i->quantity);
                                $shippingCost = $order->total_price - $subtotal;
                            @endphp
                            <span class="font-bold">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-dashed border-gray-200 my-2"></div>
                        <div class="flex justify-between text-lg font-bold text-slate-900">
                            <span>Total</span>
                            <span class="text-[#4CAF50]">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($order->payment_status == 'unpaid' && $order->shipping_status != 'cancelled')
                        <button id="pay-button" class="w-full bg-[#4CAF50] text-white py-4 rounded-xl font-bold hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-200 mb-4 animate-pulse">
                            Bayar Sekarang
                        </button>
                        <p class="text-xs text-center text-gray-400">
                            Klik tombol di atas untuk menyelesaikan pembayaran via Midtrans.
                        </p>
                    @elseif($order->payment_status == 'paid')
                        <div class="w-full bg-emerald-100 text-emerald-700 py-3 rounded-xl font-bold text-center border border-emerald-200">
                            <i class="fas fa-check-circle mr-2"></i> Lunas
                        </div>
                    @else
                        <div class="w-full bg-gray-100 text-gray-500 py-3 rounded-xl font-bold text-center">
                            Pembayaran Tidak Tersedia
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($order->payment_status == 'unpaid' && $order->snap_token)
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step
        snap.pay('{{ $order->snap_token }}', {
          // Optional
          onSuccess: function(result){
            /* You may add your own implementation here */
            // alert("payment success!"); 
            window.location.reload();
          },
          onPending: function(result){
            /* You may add your own implementation here */
            // alert("wating your payment!"); 
            window.location.reload();
          },
          onError: function(result){
            /* You may add your own implementation here */
            // alert("payment failed!"); 
            window.location.reload();
          }
        });
      };
    </script>
@endif

@endsection
