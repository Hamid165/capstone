<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dhawuh Bumi - Hidroponik Segar')</title>
    <link rel="icon" href="{{ asset('assets/tablogo.svg') }}" type="image/svg+xml">

    <!-- Tailwind CSS (CDN for Immediate Styling) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #10b981;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #059669;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen antialiased selection:bg-emerald-500 selection:text-white">

    <!-- Decorative Blobs -->
    <div class="blob w-64 h-64 rounded-full top-0 left-0 bg-emerald-200/30 -z-50 filter blur-3xl absolute"></div>
    <div class="blob w-64 h-64 rounded-full bottom-0 right-0 bg-blue-200/30 -z-50 filter blur-3xl absolute animation-delay-2000"></div>

    <nav class="fixed top-0 w-full z-50 bg-white border-b border-gray-100 shadow-sm transition-all duration-300" x-data="{ scrolled: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)">
        <div class="container mx-auto px-6 h-20 flex items-center">
            {{-- Logo Section --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('assets/logo.png') }}" class="h-10 w-auto object-contain" alt="Dhawuh Bumi Logo">
                <div>
                    <h1 class="text-xl font-bold text-[#2E4F38] leading-none tracking-tight">Dhawuh Bumi</h1>
                </div>
            </a>

            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center gap-8 font-medium text-gray-600 ml-auto mr-8">
                <a href="{{ route('home') }}" class="hover:text-[#4CAF50] transition-colors relative group py-2">
                    Home
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#4CAF50] scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </a>
                <a href="{{ route('catalog.index') }}" class="hover:text-[#4CAF50] transition-colors relative group py-2">
                    Produk
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#4CAF50] scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </a>
                <a href="{{ route('about') }}" class="hover:text-[#4CAF50] transition-colors relative group py-2">
                    Tentang Kami
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#4CAF50] scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </a>
            </div>

            {{-- Action Icons --}}
            <div class="flex items-center gap-4">

                <a href="{{ route('cart.index') }}" class="w-10 h-10 rounded-full bg-white border border-gray-100 shadow-sm flex items-center justify-center text-gray-500 hover:text-[#4CAF50] hover:shadow-md transition-all relative group">
                    <i class="fas fa-shopping-basket"></i>
                    {{-- Badge --}}
                    @auth
                        @if(Auth::user()->cartItems->count() > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-5 h-5 flex items-center justify-center rounded-full border-2 border-white">
                                {{ Auth::user()->cartItems->count() }}
                            </span>
                        @endif
                    @endauth
                </a>
                
                <div class="h-6 w-px bg-gray-200 mx-1"></div>

                @auth
                     <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 text-[#2E4F38] font-bold hover:text-[#4CAF50] focus:outline-none">
                            <div class="w-8 h-8 rounded-full bg-[#E8F5E9] flex items-center justify-center">
                                 <i class="fas fa-user text-sm"></i>
                            </div>
                            <span class="text-sm hidden md:block">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{'rotate-180': open}"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             style="display: none;"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50 overflow-hidden">
                            
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600">
                                <i class="fas fa-user-circle w-5"></i> Profil
                            </a>
                            <a href="{{ route('orders.history') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600">
                                <i class="fas fa-history w-5"></i> Riwayat Pesanan
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt w-5"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-500 hover:text-emerald-600 transition-colors mr-4">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-bold text-white bg-[#4CAF50] rounded-full hover:bg-emerald-600 shadow-md shadow-emerald-200 hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>
    
    {{-- Spacer for Fixed Navbar --}}
    <div class="h-20"></div>

    <main class="flex-grow z-10">
        @yield('content')
    </main>

    <footer class="bg-slate-900 text-white pt-24 pb-12 mt-20 relative overflow-hidden">
        <!-- Footer bg decoration -->
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 via-teal-500 to-blue-500"></div>
        <div class="absolute -top-20 -right-20 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16 border-b border-white/5 pb-12">
                <div class="col-span-1 md:col-span-2 pr-12">
                     <div class="flex items-center gap-3 mb-6">
                        <div class="bg-white p-1.5 rounded-lg">
                            <img src="{{ asset('assets/logo.png') }}" class="w-10 h-auto" alt="Logo">
                        </div>
                        <span class="text-2xl font-bold tracking-tight">Dhawuh Bumi</span>
                    </div>
                    <p class="text-slate-400 leading-relaxed font-light text-lg mb-8">
                        Menghadirkan kesegaran sayuran hidroponik premium langsung dari kebun ke meja makan Anda. Tumbuh dengan teknologi modern, bebas pestisida.
                    </p>
                    <div class="flex gap-4">
                        <a href="https://instagram.com/dhawuhbumi" target="_blank" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-slate-400 hover:bg-emerald-500 hover:text-white transition-all hover:scale-110"><i class="fab fa-instagram"></i></a>
                        <a href="https://wa.me/6285777466470" target="_blank" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-slate-400 hover:bg-emerald-500 hover:text-white transition-all hover:scale-110"><i class="fab fa-whatsapp"></i></a>
                        <!-- <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-slate-400 hover:bg-emerald-500 hover:text-white transition-all hover:scale-110"><i class="fab fa-facebook-f"></i></a> -->
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-8 text-white">Menu</h4>
                    <ul class="space-y-4 text-slate-400">
                        <li><a href="#" class="hover:text-emerald-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 group-hover:w-3 transition-all"></span> Home</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 group-hover:w-3 transition-all"></span> Produk</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 group-hover:w-3 transition-all"></span> Tentang Kami</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-8 text-white">Kontak</h4>
                    <ul class="space-y-5 text-slate-400">
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded bg-emerald-500/10 flex items-center justify-center flex-shrink-0 text-emerald-500 mt-1"><i class="fas fa-map-marker-alt text-xs"></i></div>
                            <a href="https://maps.app.goo.gl/CjS38ah81E5SFQPu8" target="_blank" class="hover:text-emerald-400 transition-colors">Karang Turi, Banyumas,<br>Jawa Tengah, Indonesia</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded bg-emerald-500/10 flex items-center justify-center flex-shrink-0 text-emerald-500"><i class="fas fa-envelope text-xs"></i></div>
                            <a href="mailto:dhawuhbumi@gmail.com" class="hover:text-emerald-400 transition-colors">dhawuhbumi@gmail.com</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center text-slate-500 text-sm">
                <div>&copy; {{ date('Y') }} Dhawuh Bumi. All rights reserved.</div>
                <div class="flex gap-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-emerald-400">Privacy Policy</a>
                    <a href="#" class="hover:text-emerald-400">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        AOS.init({
            once: true,
            duration: 800,
            offset: 100,
        });
    </script>
</body>

</html>
