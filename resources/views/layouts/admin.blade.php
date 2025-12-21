<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Dhawuh Bumi</title>
    <link rel="icon" href="{{ asset('assets/tablogo.svg') }}" type="image/svg+xml">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS (CDN for simplicity as requested, or Vite if setup) -->
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
                            950: '#022c22',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Chart.js for Dashboard -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Chart.js for Dashboard -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-emerald-900 text-white hidden md:flex flex-col flex-shrink-0 transition-all duration-300 z-50">
        <div class="h-16 flex items-center justify-center border-b border-emerald-800 bg-emerald-950">
            <div class="text-center flex items-center gap-3">
                <div class="bg-white p-1 rounded-lg">
                    <img src="{{ asset('assets/logo.png') }}" class="w-8 h-auto" alt="Logo">
                </div>
                <h1 class="text-lg font-bold tracking-wider text-white">Dhawuh Bumi</h1>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1">
            <p class="px-4 text-[10px] font-bold text-emerald-400 uppercase tracking-wider mb-2">Menu Utama</p>

            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-md' : 'text-emerald-100 hover:bg-emerald-800' }}">
                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center"><i class="fas fa-home"></i></div>
                <span class="font-medium text-sm">Dashboard</span>
            </a>

            <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('products.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-emerald-100 hover:bg-emerald-800' }}">
                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center"><i class="fas fa-leaf"></i></div>
                <span class="font-medium text-sm">Produk Tanaman</span>
            </a>

            <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('orders.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-emerald-100 hover:bg-emerald-800' }}">
                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center"><i class="fas fa-shopping-bag"></i></div>
                <span class="font-medium text-sm">Pesanan Masuk</span>
            </a>

            <div class="my-4 border-t border-emerald-800/50 mx-4"></div>

            <p class="px-4 text-[10px] font-bold text-emerald-400 uppercase tracking-wider mb-2">Lainnya</p>

            <a href="{{ route('shipping-rates.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('shipping-rates.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-emerald-100 hover:bg-emerald-800' }}">
                <div class="w-6 text-center"><i class="fas fa-truck"></i></div>
                <span class="font-medium text-sm">Ongkos Kirim</span>
            </a>

            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-xl text-emerald-100 hover:bg-emerald-800 transition-all">
                <div class="w-6 text-center"><i class="fas fa-globe"></i></div>
                <span class="font-medium text-sm">Lihat Website</span>
            </a>
        </nav>

        <div class="p-4 border-t border-emerald-800 bg-emerald-900">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-emerald-700 flex items-center justify-center text-white border border-emerald-500">
                    <i class="fas fa-user-shield text-xs"></i>
                </div>
                <div class="overflow-hidden flex-1">
                    <p class="text-sm font-semibold truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs text-emerald-300 hover:text-white transition-colors flex items-center gap-1">
                            <i class="fas fa-sign-out-alt"></i> Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden relative">
        <!-- Topbar Mobile -->
        <header class="bg-white shadow-sm border-b border-gray-100 h-16 flex items-center justify-between px-6 md:hidden z-40">
            <div class="flex items-center gap-3">
                <button class="text-gray-500 hover:text-emerald-600">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <span class="font-bold text-emerald-900">Dhawuh Bumi</span>
            </div>
            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-700">
                <i class="fas fa-user"></i>
            </div>
        </header>

        <!-- Content Body -->
        <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
            <!-- Breadcrumb / Header -->
            <div class="mb-6 flex justify-between items-end">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        @yield('header', View::hasSection('title') ? View::getSection('title') : 'Dashboard')
                    </h2>
                    <p class="text-gray-500 text-sm mt-1">Selamat datang kembali, Admin!</p>
                </div>
                <div class="hidden md:block text-sm text-gray-400">
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
            </div>

            <!-- Flash Message -->
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="text-emerald-500"><i class="fas fa-check-circle"></i></div>
                        <p class="text-sm text-emerald-800 font-medium">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600"><i class="fas fa-times"></i></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</div>

</body>
</html>
