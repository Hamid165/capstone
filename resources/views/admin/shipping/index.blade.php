@extends('layouts.admin')

@section('title', 'Manajemen Ongkos Kirim')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Form Tambah Wilayah -->
    <div class="md:col-span-1">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Tambah Wilayah Baru</h3>
            
            <form action="{{ route('shipping-rates.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Kabupaten/Kota</label>
                    <input type="text" name="destination_city" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500"
                           placeholder="Contoh: Kabupaten Cilacap">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Harga Ongkir (Rp)</label>
                    <input type="number" name="price" required min="0" step="500"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500"
                           placeholder="Contoh: 15000">
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg transition-colors shadow-lg shadow-emerald-600/20">
                    <i class="fas fa-plus mr-1"></i> Tambah Data
                </button>
            </form>
        </div>
    </div>

    <!-- Tabel Daftar Ongkir -->
    <div class="md:col-span-2">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-800">Daftar Tarif Ongkir</h3>
                <span class="text-xs font-medium text-gray-500 bg-white px-2 py-1 rounded border border-gray-200">
                    Total: {{ $rates->count() }} Wilayah
                </span>
            </div>
            
            <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-gray-500 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th class="px-5 py-3 text-xs font-bold uppercase">Wilayah Tujuan</th>
                            <th class="px-5 py-3 text-xs font-bold uppercase">Harga</th>
                            <th class="px-5 py-3 text-xs font-bold uppercase text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($rates as $rate)
                        <tr class="hover:bg-gray-50 group">
                            <td class="px-5 py-3 text-sm font-medium text-gray-700">{{ $rate->destination_city }}</td>
                            <td class="px-5 py-3 text-sm text-emerald-600 font-bold">
                                {{-- Form Edit Harga Inline --}}
                                <form action="{{ route('shipping-rates.update', $rate->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <span class="text-gray-400 text-xs">Rp</span>
                                    <input type="number" name="price" value="{{ $rate->price }}" 
                                           class="w-24 px-2 py-1 text-sm border-transparent bg-transparent hover:bg-white hover:border-gray-300 focus:bg-white focus:border-emerald-500 rounded transition-all font-bold text-emerald-600">
                                    <button type="submit" class="text-xs bg-emerald-100 text-emerald-700 px-2 py-1 rounded hidden group-hover:inline-block hover:bg-emerald-200">
                                        Update
                                    </button>
                                </form>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div x-data="{ open: false }">
                                    <button @click="open = true" type="button" class="text-red-400 hover:text-red-600 transition-colors" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>

                                    {{-- Delete Confirmation Modal --}}
                                    <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak>
                                        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 transform transition-all text-center" @click.away="open = false">
                                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 text-red-500 text-2xl">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </div>
                                            <h3 class="text-lg font-bold text-slate-800 mb-2">Hapus Tarif?</h3>
                                            <p class="text-gray-500 text-sm mb-6">Apakah Anda yakin ingin menghapus data ongkir untuk wilayah ini?</p>
                                            
                                            <div class="flex gap-3 justify-center">
                                                <button @click="open = false" type="button" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-bold text-sm hover:bg-gray-50 transition-colors">
                                                    Batal
                                                </button>
                                                <form action="{{ route('shipping-rates.destroy', $rate->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-red-500 text-white font-bold text-sm hover:bg-red-600 transition-colors shadow-lg shadow-red-200">
                                                        Ya, Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-5 py-8 text-center text-gray-400 text-sm">
                                Belum ada data tarif ongkir.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
