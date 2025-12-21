@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Card 1: Total Pendapatan -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Pendapatan</p>
            <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <p class="text-xs text-emerald-500 mt-1 font-medium">Tahun {{ date('Y') }}</p>
        </div>
        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xl">
            <i class="fas fa-wallet"></i>
        </div>
    </div>

    <!-- Card 2: Pesanan Baru -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Pesanan Baru</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $newOrdersCount }}</h3>
            <p class="text-xs text-blue-500 mt-1 font-medium">Perlu diproses</p>
        </div>
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xl">
            <i class="fas fa-shopping-cart"></i>
        </div>
    </div>

    <!-- Card 3: Total Produk -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Produk</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $totalProducts }}</h3>
            <p class="text-xs text-gray-400 mt-1 font-medium">Item aktif</p>
        </div>
        <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-xl">
            <i class="fas fa-box-open"></i>
        </div>
    </div>

    <!-- Card 4: Pelanggan -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Pelanggan</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalCustomers) }}</h3>
            <p class="text-xs text-emerald-500 mt-1 font-medium">Terdaftar</p>
        </div>
        <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-xl">
            <i class="fas fa-users"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Chart: Penjualan -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Statistik Penjualan ({{ date('Y') }})</h3>
        <canvas id="salesChart" height="250"></canvas>
    </div>

    <!-- Latest Orders -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Pesanan Terbaru</h3>
            <a href="{{ route('orders.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-3 py-2">ID</th>
                        <th class="px-3 py-2">Pelanggan</th>
                        <th class="px-3 py-2">Total</th>
                        <th class="px-3 py-2">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentOrders as $order)
                        <tr>
                            <td class="px-3 py-3 font-mono">#{{ $order->id }}</td>
                            <td class="px-3 py-3">{{ $order->user->name ?? 'Guest' }}</td>
                            <td class="px-3 py-3 text-emerald-600 font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="px-3 py-3">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'processing' => 'bg-blue-100 text-blue-700',
                                        'shipped' => 'bg-purple-100 text-purple-700',
                                        'completed' => 'bg-emerald-100 text-emerald-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                    ];
                                    $class = $statusClasses[$order->shipping_status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="{{ $class }} px-2 py-1 rounded text-xs font-bold capitalize">{{ $order->shipping_status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-400">Belum ada pesanan terbaru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($chartData) !!},
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value, index, values) {
                            return new Intl.NumberFormat('id-ID', { compactDisplay: "short", notation: "compact" }).format(value);
                        }
                    }
                }
            }
        }
    });
</script>
@endsection