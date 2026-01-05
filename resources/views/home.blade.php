@extends('layouts.app')

@section('content')

{{-- 1. Hero Section (Split Layout: Text Left, Image Right) --}}
<section class="lg:min-h-[75vh] flex flex-col items-center relative overflow-hidden">
    <div class="w-full flex flex-col md:flex-row h-full flex-grow">
        {{-- Left: Text Content --}}
        <div class="w-full md:w-1/2 bg-[#2E4F38] flex flex-col justify-center px-8 md:px-16 lg:px-24 pt-20 pb-32 lg:pb-48 relative z-20 text-white">
            <div data-aos="fade-right" data-aos-duration="1000">
                <div class="flex items-center gap-2 mb-6 text-emerald-300 font-bold tracking-widest uppercase text-xs">
                    <span class="w-8 h-[2px] bg-emerald-300"></span>
                    Fresh From Farm
                </div>

                <h1 class="text-5xl lg:text-7xl font-bold font-serif leading-[1.1] mb-8">
                    Pertanian Modern, <br>
                    <span class="text-emerald-400">Sehat</span>, dan Berkelanjutan.
                </h1>
                
                <p class="text-lg text-emerald-100/90 leading-relaxed mb-10 max-w-lg border-l-4 border-emerald-500 pl-6">
                    "Dhawuh Bumi" adalah inisiatif nyata untuk regenerasi petani muda Indonesia dengan teknologi hidroponik cerdas.
                </p>
                
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('catalog.index') }}" class="px-8 py-4 bg-[#4CAF50] hover:bg-emerald-500 text-white font-bold rounded-lg shadow-lg shadow-emerald-900/20 transform hover:-translate-y-1 transition-all">
                        Lihat Produk
                    </a>
                    <a href="{{ route('about') }}" class="px-8 py-4 border border-emerald-400 text-emerald-300 font-bold rounded-lg hover:bg-emerald-900/50 transition-all">
                        Pelajari Kami
                    </a>
                </div>
            </div>

            {{-- Background Texture --}}
            <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
        </div>

        {{-- Right: Hero Image --}}
        <div class="w-full md:w-1/2 relative h-[50vh] md:h-auto overflow-hidden">
            <img src="{{ asset('assets/dawuhbumi10.jpg') }}" 
                 alt="Greenhouse Modern" 
                 class="absolute inset-0 w-full h-full object-cover object-center transform scale-125 hover:scale-135 transition-transform duration-[2000ms]">
            
            {{-- Gradient Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-l from-transparent via-transparent to-[#2E4F38]/20"></div>
        </div>
    </div>
</section>

{{-- 2. USP Section (Floating – Extra Bottom Space) --}}
<section class="relative z-30 -mt-20 lg:-mt-24 min-h-[90vh] flex items-center">
    
    {{-- Floating Cards --}}
    <div class="w-[95%] max-w-[1600px] mx-auto">
        <div class="text-center mb-16 mt-32" data-aos="fade-down">
            <h2 class="text-6xl font-bold font-serif text-slate-900 mb-4 drop-shadow-sm tracking-wide">Keunggulan</h2>
            <div class="w-32 h-2 bg-[#4CAF50] mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 rounded-[2.5rem] overflow-hidden
                    shadow-[0_40px_90px_-20px_rgba(0,0,0,0.28)]
                    backdrop-blur-sm">

            {{-- Card 1 --}}
            <div class="bg-orange-400 px-12 py-20 min-h-[350px] flex flex-col items-center justify-center text-white text-center relative overflow-hidden">
                <div class="w-24 h-24 mb-8 rounded-full border-2 border-white/30 flex items-center justify-center text-5xl bg-white/10 relative">
                    <i class="fas fa-capsules"></i>
                    <i class="fas fa-ban absolute text-red-500/80 text-6xl"></i>
                </div>
                <h3 class="text-3xl font-bold font-serif mb-3">Tanpa Pestisida</h3>
                <p class="text-lg text-white/90 max-w-xs">Produk segar tanpa bahan kimia berbahaya.</p>
                <i class="fas fa-capsules absolute -bottom-16 -right-16 text-[13rem] text-white/10 rotate-12"></i>
            </div>

            {{-- Card 2 --}}
            <div class="bg-emerald-500 px-12 py-20 min-h-[350px] flex flex-col items-center justify-center text-white text-center relative overflow-hidden">
                <div class="w-24 h-24 mb-8 rounded-full border-2 border-white/30 flex items-center justify-center text-5xl bg-white/10">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3 class="text-3xl font-bold font-serif mb-3">Ramah Lingkungan</h3>
                <p class="text-lg text-white/90 max-w-xs">Sistem hidroponik hemat air & energi.</p>
                <i class="fas fa-leaf absolute -bottom-16 -right-16 text-[13rem] text-white/10 rotate-12"></i>
            </div>

            {{-- Card 3 --}}
            <div class="bg-[#2E4F38] px-12 py-20 min-h-[350px] flex flex-col items-center justify-center text-white text-center relative overflow-hidden">
                <div class="w-24 h-24 mb-8 rounded-full border-2 border-white/30 flex items-center justify-center text-5xl bg-white/10">
                    <i class="fas fa-stopwatch"></i>
                </div>
                <h3 class="text-3xl font-bold font-serif mb-3">Tahan Lebih Lama</h3>
                <p class="text-lg text-white/90 max-w-xs">Panen saat dipesan, kesegaran maksimal.</p>
                <i class="fas fa-history absolute -bottom-16 -right-16 text-[13rem] text-white/10 rotate-12"></i>
            </div>

        </div>
    </div>

    {{-- Bottom Spacer (THIS is the magic 🧠) --}}
    <div class="h-40 lg:h-56"></div>
</section>


{{-- 3. Produk Unggulan --}}
<section id="katalog" class="py-24 bg-white relative">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 px-4">
            <div class="relative pl-6 border-l-4 border-[#2E4F38]">
                <h2 class="text-4xl font-bold text-gray-900 font-serif" data-aos="fade-right">Produk Unggulan</h2>
                <p class="text-gray-500 mt-2 text-lg">Dipetik langsung dari kebun kami hari ini.</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="group hidden md:flex items-center gap-2 text-[#2E4F38] font-bold hover:text-emerald-600 transition-colors">
                Lihat Semua <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($bestSellers as $index => $product)
            <a href="{{ route('catalog.show', $product->slug) }}" class="group bg-white rounded-2xl shadow-xl shadow-gray-200/50 overflow-hidden hover:-translate-y-2 transition-transform duration-300 block" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                {{-- Image Container --}}
                <div class="relative h-52 overflow-hidden">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                         class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700">
                    
                    {{-- Badge --}}
                    <div class="absolute top-4 left-4 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded shadow-sm">
                        <i class="fas fa-star mr-1"></i> FAVORITE
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6">
                    <h3 class="font-bold text-gray-800 text-lg mb-2 truncate font-serif">{{ $product->name }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">
                        {{ Str::limit($product->description, 60, '...') }}
                    </p>
                </div>
            </a>
            @empty
             <div class="col-span-full py-20 text-center bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                <p class="text-gray-400 text-lg">Belum ada produk unggulan yang ditampilkan.</p>
             </div>
            @endforelse
        </div>
        
        <div class="mt-12 text-center md:hidden">
            <a href="{{ route('catalog.index') }}" class="inline-block px-8 py-3 bg-gray-100 text-gray-700 font-bold rounded-full hover:bg-gray-200">
                Lihat Semua Produk
            </a>
        </div>
    </div>
</section>

{{-- 4. Gallery Section (Split) --}}
<section class="flex flex-col md:flex-row h-auto md:h-[600px] overflow-hidden">
    {{-- Left: Image --}}
    <div class="w-full md:w-1/2 relative h-80 md:h-full group overflow-hidden">
        <img src="{{ asset('assets/dawuhbumi1.jpg') }}" class="absolute inset-0 w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-1000">
        <div class="absolute inset-0 bg-[#2E4F38]/20 mix-blend-multiply"></div>
    </div>

    {{-- Right: Content --}}
    <div class="w-full md:w-1/2 bg-[#2E4F38] text-white p-12 lg:p-24 flex flex-col justify-center relative">
        {{-- Decorative Pattern --}}
        <i class="fas fa-quote-right absolute top-12 right-12 text-6xl text-white/5"></i>
        
        <h2 class="text-4xl font-bold font-serif mb-8" data-aos="fade-left">Tumbuh Bersama <br>Komunitas</h2>
        <div class="space-y-6 text-lg text-emerald-100/80 font-light leading-relaxed mb-10">
            <p>
                "Dari lahan sempit, tumbuh harapan luas. Dhawuh Bumi mengajak masyarakat untuk mandiri pangan melalui pekarangan sendiri."
            </p>
            <p>
                Kami aktif mengadakan pelatihan rutin setiap minggu untuk pemuda desa.
            </p>
        </div>
    </div>
</section>

{{-- 5. Education Section --}}
<section class="py-24 bg-[#F8F9FA]">
    <div class="container mx-auto px-6">
        <div class="text-center mb-20">
            <h2 class="text-4xl font-bold text-gray-900 font-serif mb-4">Program Edukasi</h2>
            <div class="w-24 h-1 bg-[#4CAF50] mx-auto rounded-full"></div>
            <p class="text-gray-500 mt-6 max-w-2xl mx-auto text-lg">Kami berbagi pengetahuan untuk masa depan pertanian yang lebih baik.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto px-4">
            {{-- Card 1: SD & SMP --}}
            <div class="bg-white rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all group cursor-pointer h-full flex flex-col" data-aos="zoom-in-up">
                <div class="h-56 overflow-hidden relative shrink-0">
                    <img src="{{ asset('assets/sd_smp.jpeg') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors"></div>
                    <div class="absolute bottom-6 left-6 text-white w-[90%]">
                        <span class="bg-[#4CAF50] px-3 py-1 text-xs font-bold rounded-md mb-2 inline-block">PEMULA</span>
                        <h3 class="text-xl font-bold leading-tight">Siswa SD & SMP</h3>
                    </div>
                </div>
                <div class="p-6 flex-grow">
                     <p class="text-gray-600 leading-relaxed text-sm">
                        Pengenalan budidaya hidroponik dan praktik penanaman
                    </p>
                </div>
            </div>

            {{-- Card 2: Mahasiswa --}}
             <div class="bg-white rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all group cursor-pointer h-full flex flex-col" data-aos="zoom-in-up" data-aos-delay="100">
                <div class="h-56 overflow-hidden relative shrink-0">
                    <img src="{{ asset('assets/mahasiswa.jpeg') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors"></div>
                    <div class="absolute bottom-6 left-6 text-white w-[90%]">
                        <span class="bg-blue-600 px-3 py-1 text-xs font-bold rounded-md mb-2 inline-block">LANJUTAN</span>
                        <h3 class="text-xl font-bold leading-tight">Mahasiswa & Profesional Universitas</h3>
                    </div>
                </div>
                <div class="p-6 flex-grow">
                     <p class="text-gray-600 leading-relaxed text-sm">
                        Kunjungan lapangan, pelatihan langsung, dan diskusi tentang hidroponik
                    </p>
                </div>
            </div>

            {{-- Card 3: Lokakarya --}}
            <div class="bg-white rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all group cursor-pointer h-full flex flex-col" data-aos="zoom-in-up" data-aos-delay="200">
                <div class="h-56 overflow-hidden relative shrink-0">
                    <img src="{{ asset('assets/lokakarya.jpeg') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors"></div>
                    <div class="absolute bottom-6 left-6 text-white w-[90%]">
                        <span class="bg-orange-500 px-3 py-1 text-xs font-bold rounded-md mb-2 inline-block">UMUM</span>
                        <h3 class="text-xl font-bold leading-tight">Lokakarya Umum</h3>
                    </div>
                </div>
                <div class="p-6 flex-grow">
                     <p class="text-gray-600 leading-relaxed text-sm">
                        Pelatihan hidroponik rumahan untuk keluarga dan komunitas perkotaan
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection