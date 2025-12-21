@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div
        class="relative bg-gradient-to-r from-emerald-600 to-teal-500 rounded-2xl p-6 md:p-10 shadow-lg mb-8 text-white overflow-hidden">
        <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
        <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
                <p class="text-emerald-50 opacity-90">Hari ini adalah waktu yang tepat untuk mengecek stok tanaman
                    hidroponik.</p>
            </div>
            <a href="{{ route('products.create') }}"
                class="bg-white text-emerald-600 hover:bg-emerald-50 px-6 py-3 rounded-xl font-semibold shadow-md transition transform hover:-translate-y-1 flex items-center gap-2">
                <i class="fas fa-plus-circle"></i> Tambah Produk Baru
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Tanaman</p>
                <h3 class="text-3xl font-bold text-gray-800">120 <span class="text-sm font-normal text-gray-400">Pcs</span>
                </h3>
            </div>
            <div
                class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-2xl shadow-inner">
                <i class="fas fa-leaf"></i>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Pesanan Baru</p>
                <h3 class="text-3xl font-bold text-gray-800">5 <span class="text-sm font-normal text-gray-400">Order</span>
                </h3>
            </div>
            <div
                class="w-14 h-14 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-2xl shadow-inner">
                <i class="fas fa-shopping-basket"></i>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Pendapatan</p>
                <h3 class="text-3xl font-bold text-gray-800">Rp 2.5jt</h3>
            </div>
            <div
                class="w-14 h-14 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center text-2xl shadow-inner">
                <i class="fas fa-wallet"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Aksi Cepat</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <a href="{{ route('products.index') }}"
                    class="group p-4 rounded-xl border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50 transition flex flex-col items-center text-center">
                    <div
                        class="w-12 h-12 mb-3 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-xl group-hover:scale-110 transition">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-600 group-hover:text-emerald-700">Kelola Produk</span>
                </a>

                <a href="#"
                    class="group p-4 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50 transition flex flex-col items-center text-center">
                    <div
                        class="w-12 h-12 mb-3 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-xl group-hover:scale-110 transition">
                        <i class="fas fa-truck-loading"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-600 group-hover:text-blue-700">Cek Pesanan</span>
                </a>

                <a href="#"
                    class="group p-4 rounded-xl border border-gray-100 hover:border-purple-200 hover:bg-purple-50 transition flex flex-col items-center text-center">
                    <div
                        class="w-12 h-12 mb-3 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center text-xl group-hover:scale-110 transition">
                        <i class="fas fa-users"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-600 group-hover:text-purple-700">Data Pelanggan</span>
                </a>

                <a href="#"
                    class="group p-4 rounded-xl border border-gray-100 hover:border-orange-200 hover:bg-orange-50 transition flex flex-col items-center text-center">
                    <div
                        class="w-12 h-12 mb-3 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center text-xl group-hover:scale-110 transition">
                        <i class="fas fa-cog"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-600 group-hover:text-orange-700">Pengaturan</span>
                </a>

            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-exclamation-circle text-red-500"></i> Stok Menipis
            </h3>

            <div class="space-y-4">
                <div class="flex items-center gap-4 p-3 rounded-lg bg-red-50 hover:bg-red-100 transition">
                    <div class="w-10 h-10 bg-white rounded-md flex items-center justify-center text-red-500 shadow-sm">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-gray-800">Sawi Pakcoy</h4>
                        <p class="text-xs text-red-600 font-semibold">Sisa: 2 Pcs</p>
                    </div>
                    <a href="#"
                        class="text-xs bg-white px-2 py-1 rounded border shadow-sm text-gray-600 hover:text-emerald-600">Update</a>
                </div>

                <div class="flex items-center gap-4 p-3 rounded-lg bg-red-50 hover:bg-red-100 transition">
                    <div class="w-10 h-10 bg-white rounded-md flex items-center justify-center text-red-500 shadow-sm">
                        <i class="fas fa-carrot"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-gray-800">Wortel Baby</h4>
                        <p class="text-xs text-red-600 font-semibold">Sisa: 0 Pcs</p>
                    </div>
                    <a href="#"
                        class="text-xs bg-white px-2 py-1 rounded border shadow-sm text-gray-600 hover:text-emerald-600">Update</a>
                </div>
            </div>

            <a href="{{ route('products.index') }}"
                class="block text-center mt-4 text-sm text-emerald-600 font-medium hover:underline">Lihat Semua Stok</a>
        </div>
    </div>
@endsection
