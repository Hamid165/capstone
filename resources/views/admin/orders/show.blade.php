@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Kolom Kiri: Detail Items -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Card Barang -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <div class="p-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Barang Pesanan</h3>
                <span class="text-sm text-gray-500">{{ $order->items->count() }} Item</span>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($order->items as $item)
                <div class="p-4 flex gap-4">
                    <div class="w-16 h-16 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                        @if($item->product && $item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-image"></i></div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800">{{ $item->product->name ?? 'Produk Dihapus' }}</h4>
                        <p class="text-sm text-gray-500">Rp {{ number_format($item->price, 0, ',', '.') }} x {{ $item->quantity }} pcs</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-emerald-600">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="p-4 bg-gray-50 border-t border-gray-100 text-right">
                <p class="text-sm text-gray-500">Subtotal Barang</p>
                <p class="text-xl font-bold text-emerald-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p> <!-- Simplified, assume total_price includes shipping logic later -->
            </div>
        </div>

        <!-- Card Info Pengiriman -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Informasi Pengiriman</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500 mb-1">Penerima</p>
                    <p class="font-bold text-gray-800">{{ $order->user->name ?? 'Guest' }}</p>
                    <p class="text-gray-600">{{ $order->user->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">Alamat Tujuan</p>
                    <p class="font-semibold text-gray-800">{{ $order->shippingRate->destination_city ?? 'Wilayah Tidak Diketahui' }}</p>
                    <p class="text-gray-600 mt-1">{{ $order->shipping_address_detail ?? 'Alamat detail belum diisi user.' }}</p>
                </div>
                <div class="md:col-span-2 mt-2">
                    {{-- Resi removed per request --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Aksi -->
    <div class="space-y-6">
        <!-- Status Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4">Status Pesanan</h3>
            
            <form action="{{ route('orders.update-status', $order->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Ubah Status</label>
                    <select name="shipping_status" id="statusSelect" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="pending" {{ $order->shipping_status == 'pending' ? 'selected' : '' }}>Checking Payment (Pending)</option>
                        <option value="processing" {{ $order->shipping_status == 'processing' ? 'selected' : '' }}>Sedang Dikemas (Processing)</option>
                        <option value="shipped" {{ $order->shipping_status == 'shipped' ? 'selected' : '' }}>Sedang Dikirim (Shipped)</option>
                        <option value="completed" {{ $order->shipping_status == 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 rounded-lg transition-colors">
                    Update Status
                </button>
            </form>
        </div>

        <!-- Action Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4">Aksi Lainnya</h3>
            <a href="{{ route('orders.print', $order->id) }}" target="_blank" class="w-full flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 rounded-lg transition-colors mb-2">
                <i class="fas fa-print"></i> Cetak Invoice
            </a>
            <a href="https://wa.me/6285777466470?text=Halo%20{{ $order->user->name ?? 'Kak' }},%20pesanan%20Anda%20dengan%20ID%20{{ $order->id }}%20sedang%20diproses." target="_blank" class="w-full flex items-center justify-center gap-2 bg-green-100 hover:bg-green-200 text-green-700 font-medium py-2 rounded-lg transition-colors">
                <i class="fab fa-whatsapp"></i> Hubungi Pembeli (Admin)
            </a>
        </div>
    </div>

</div>
@endsection
