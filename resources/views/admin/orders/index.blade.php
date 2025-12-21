@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
    <div class="p-6 border-b border-gray-100">
        <form action="{{ route('orders.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <input type="hidden" name="status" value="{{ request('status', 'all') }}">
            
            {{-- Search Box --}}
            <div class="flex-grow relative">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm" 
                       placeholder="Cari ID Order atau Nama Pelanggan...">
            </div>

            {{-- Date Filter --}}
            <div class="relative">
                <i class="fas fa-calendar absolute left-3 top-3 text-gray-400"></i>
                <input type="date" name="date" value="{{ request('date') }}" 
                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm text-gray-600">
            </div>

            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg font-bold text-sm transition-colors shadow-lg shadow-emerald-200">
                Filter
            </button>
            
            @if(request('search') || request('date'))
                <a href="{{ route('orders.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 text-sm font-bold flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>
    <!-- Filter Tabs -->
    <div class="border-b border-gray-100 flex overflow-x-auto">
        @php
            $statuses = [
                'all' => 'Semua Pesanan',
                'pending' => 'Menunggu Bayar',
                'processing' => 'Perlu Diproses',
                'shipped' => 'Dikirim',
                'completed' => 'Selesai'
            ];
            $currentStatus = request('status', 'all');
            
            // Helper to build URL with existing params
            function buildFilterUrl($status) {
                $params = request()->all();
                $params['status'] = $status;
                return route('orders.index', $params);
            }
        @endphp

        @foreach($statuses as $key => $label)
             <a href="{{ buildFilterUrl($key) }}" 
               class="px-6 py-4 text-sm font-medium whitespace-nowrap {{ $currentStatus == $key ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-500 hover:text-gray-700' }}">
               {{ $label }}
            </a>
        @endforeach
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-500 text-xs font-bold uppercase">
                <tr>
                    <th class="px-6 py-3">ID Order</th>
                    <th class="px-6 py-3">Pelanggan</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-mono font-medium text-emerald-700">#{{ $order->id }}</td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800">{{ $order->user->name ?? 'Guest' }}</p>
                        <p class="text-xs text-gray-400">{{ $order->user->email ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-500">
                        {{ $order->created_at->format('d M Y H:i') }}
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-800">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $badges = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'processing' => 'bg-blue-100 text-blue-700',
                                'shipped' => 'bg-purple-100 text-purple-700',
                                'completed' => 'bg-green-100 text-green-700',
                            ];
                            $labels = [
                                'pending' => 'Menunggu Pembayaran',
                                'processing' => 'Sedang Diproses',
                                'shipped' => 'Dikirim',
                                'completed' => 'Selesai',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badges[$order->shipping_status] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $labels[$order->shipping_status] ?? ucfirst($order->shipping_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">
                            Lihat Detail <i class="fas fa-arrow-right"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        <div class="mb-2"><i class="fas fa-inbox text-4xl"></i></div>
                        Belum ada pesanan masuk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-t border-gray-100">
        {{ $orders->links() }}
    </div>
</div>
@endsection