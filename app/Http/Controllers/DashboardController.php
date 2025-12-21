<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Pendapatan (Hanya dari pesanan yang sudah dibayar)
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_price');

        // 2. Pesanan Baru (Yang perlu diproses / status pending/processing)
        $newOrdersCount = Order::whereIn('shipping_status', ['pending', 'processing'])->count();

        // 3. Total Produk
        $totalProducts = Product::count();

        // 4. Total Pelanggan (Role customer)
        $totalCustomers = User::where('role', 'customer')->count();

        // 5. Pesanan Terbaru (5 Transaksi Terakhir)
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // 6. Data Grafik Penjualan (Per Bulan di Tahun Ini)
        $salesData = Order::where('payment_status', 'paid')
            ->whereYear('created_at', date('Y'))
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Format data untuk Chart.js (12 Bulan)
        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartData = [];

        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $salesData[$i] ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalRevenue',
            'newOrdersCount',
            'totalProducts',
            'totalCustomers',
            'recentOrders',
            'chartLabels',
            'chartData'
        ));
    }
}
