@extends('layouts.app')

@section('title', 'Tentang Kami - Dhawuh Bumi')

@section('content')
<div class="font-sans overflow-x-hidden">
    
    {{-- 1. Hero Section Parallax --}}
    <div class="relative h-[80vh] flex items-center justify-center bg-fixed bg-center bg-cover" 
         style="background-image: url('{{ asset('assets/dawuhbumi2.jpg') }}');">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 text-center px-6" data-aos="fade-up">
            <h1 class="text-6xl md:text-8xl font-bold text-white mb-6 font-serif drop-shadow-2xl">Dhawuh Bumi</h1>
            <p class="text-2xl md:text-3xl text-emerald-100 font-light italic tracking-wider">
                "Menanam, Tetap Membumi, dan Mandiri."
            </p>
            <div class="mt-12">
                <a href="#cerita-kami" class="inline-block px-10 py-4 border-2 border-white text-white rounded-full hover:bg-white hover:text-emerald-900 transition-all duration-300 font-bold tracking-widest uppercase">
                    Cerita Kami
                </a>
            </div>
        </div>
        
        {{-- Scroll Indicator --}}
        <div class="absolute bottom-10 left-0 w-full flex justify-center animate-bounce">
            <i class="fas fa-chevron-down text-white text-3xl opacity-70"></i>
        </div>
    </div>

    {{-- 2. Our Journey Section (Clean & Modern) --}}
    <section id="cerita-kami" class="py-24 md:py-32 bg-gray-50 relative">
        <div class="container mx-auto px-6 max-w-5xl">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-center">
                {{-- Decorative Line --}}
                <div class="hidden md:block md:col-span-1 h-32 w-[2px] bg-emerald-300 mx-auto"></div>
                
                <div class="md:col-span-11">
                    <span class="block text-emerald-600 font-bold tracking-[0.3em] text-sm uppercase mb-4" data-aos="fade-right">Sejarah Kami</span>
                    <h2 class="text-4xl md:text-6xl font-bold text-slate-800 mb-10 font-serif" data-aos="fade-up">Akar yang Kuat untuk Masa Depan</h2>
                    
                    <div class="bg-white p-10 md:p-14 rounded-[3rem] shadow-xl shadow-gray-200/50" data-aos="fade-up" data-aos-delay="100">
                        <p class="text-gray-600 text-lg md:text-xl leading-relaxed font-light first-letter:text-5xl first-letter:font-serif first-letter:text-emerald-600 first-letter:mr-3 first-letter:float-left">
                            Dhawuh Bumi Hydroponics lahir dari sebuah visi sederhana namun kuat pada Juni 2024. Kami hadir sebagai jawaban atas tantangan pertanian masa depan, memadukan teknologi hidroponik modern dengan kearifan lokal. Fokus kami bukan hanya sekadar menanam, tetapi membangun ekosistem pangan yang berkelanjutan, sehat, dan dapat diakses oleh semua lapisan masyarakat.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. Philosophy & Identity (Premium Dark) --}}
    <section class="bg-[#2E4F38] py-32 relative overflow-hidden">
        {{-- Abstract Shapes --}}
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-emerald-400/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-black/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                
                {{-- Left: Content --}}
                <div class="order-2 lg:order-1" data-aos="fade-right">
                    <h2 class="text-white text-5xl md:text-6xl font-serif font-bold mb-12">Filosofi</h2>
                    
                    <div class="space-y-12">
                        <div class="relative group">
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-emerald-500/50 group-hover:bg-emerald-400 transition-colors"></div>
                            <div class="pl-8">
                                <h3 class="text-emerald-200 text-2xl font-bold mb-4">Arti Nama</h3>
                                <p class="text-emerald-50/80 text-lg leading-relaxed">
                                    <span class="text-white font-serif italic">"Dhawuh Bumi"</span> berarti "Perintah Bumi". Sebuah pengingat bahwa kita bekerja selaras dengan alam, bukan melawannya. Setiap benih yang kami tanam adalah bentuk penghormatan kami kepada bumi.
                                </p>
                            </div>
                        </div>

                        <div class="relative group">
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-emerald-500/50 group-hover:bg-emerald-400 transition-colors"></div>
                            <div class="pl-8">
                                <h3 class="text-emerald-200 text-2xl font-bold mb-4">Misi Sosial</h3>
                                <p class="text-emerald-50/80 text-lg leading-relaxed">
                                    Kami bergerak untuk mengatasi krisis regenerasi petani muda. Dengan hidroponik, kami membuktikan bahwa bertani bisa modern, bersih, dan menguntungkan—menarik kembali minat generasi muda untuk kembali ke tanah.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Visual Identity --}}
                <div class="order-1 lg:order-2 flex justify-center" data-aos="zoom-in" data-aos-duration="1000">
                    <div class="relative w-80 h-80 md:w-[500px] md:h-[500px]">
                        {{-- White Circle Container for Logo --}}
                        <div class="absolute inset-0 bg-white rounded-full flex items-center justify-center p-12 shadow-[0_0_50px_rgba(255,255,255,0.2)]">
                             <img src="{{ asset('assets/logo.png') }}" alt="Logo Dhawuh Bumi" class="w-full h-full object-contain">
                        </div>
                        
                        {{-- Badge 'Sejak 2024' --}}
                        <div class="absolute top-0 right-0 md:top-4 md:right-4 transform translate-x-1/4 -translate-y-1/4 md:translate-x-0 md:-translate-y-0">
                             <div class="relative w-28 h-28 md:w-32 md:h-32 bg-gradient-to-br from-[#4CAF50] to-[#2E7D32] rounded-full flex items-center justify-center p-1 shadow-2xl border-4 border-[#2E4F38] group hover:scale-110 transition-transform duration-300 cursor-default">
                                <div class="w-full h-full rounded-full border border-white/30 flex flex-col items-center justify-center text-white">
                                     <span class="text-xs font-medium uppercase tracking-widest opacity-80">Sejak</span>
                                     <span class="text-2xl md:text-3xl font-bold font-serif -mt-1">2024</span>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- 4. Location Section (Simple & Elegant) --}}
    <section class="py-24 bg-white relative">
         <div class="container mx-auto px-6 text-center max-w-3xl">
             <i class="fas fa-map-marker-alt text-4xl text-emerald-500 mb-6" data-aos="fade-up"></i>
             <h3 class="text-3xl text-slate-800 font-bold mb-6 font-serif" data-aos="fade-up">Kunjungi Kebun Kami</h3>
             <p class="text-xl text-gray-500 font-light mb-8" data-aos="fade-up">
                 Desa Karang Turi, Kecamatan Sumbang,<br>Kabupaten Banyumas, Jawa Tengah
             </p>
             <a href="https://maps.app.goo.gl/CjS38ah81E5SFQPu8" target="_blank" class="inline-flex items-center bg-[#4CAF50] text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-emerald-600 hover:shadow-xl transition-all transform hover:-translate-y-1" data-aos="fade-up">
                 <i class="fas fa-map-marked-alt mr-2"></i> Lihat di Google Maps
             </a>
         </div>
    </section>

</div>
@endsection
