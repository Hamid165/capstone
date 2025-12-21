<aside class="w-full md:w-64 bg-emerald-900 text-white flex-shrink-0 md:h-screen md:fixed transition-all duration-300 z-50">
    
    <div class="h-20 flex items-center justify-center border-b border-emerald-800 bg-emerald-950">
        <div class="text-center">
            <i class="fas fa-seedling text-3xl text-emerald-400 mb-1"></i>
            <h1 class="text-xl font-bold tracking-wider text-white">Dhawuh Bumi</h1>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-2">
        
        <p class="px-4 text-xs font-semibold text-emerald-400 uppercase mb-2">Menu Utama</p>
        
        <a href="{{ route('dashboard') }}" 
           class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-emerald-700 text-white shadow-lg' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
            <i class="fas fa-home w-6"></i>
            <span class="font-medium">Dashboard</span>
        </a>

        <a href="{{ route('products.index') }}" 
           class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('products.*') ? 'bg-emerald-700 text-white shadow-lg' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
            <i class="fas fa-leaf w-6"></i>
            <span class="font-medium">Data Produk</span>
        </a>

        <a href="#" class="flex items-center px-4 py-3 rounded-lg text-emerald-100 hover:bg-emerald-800 hover:text-white transition-colors">
            <i class="fas fa-shopping-basket w-6"></i>
            <span class="font-medium">Pesanan Masuk</span>
        </a>

        <div class="my-4 border-t border-emerald-800"></div>

        <p class="px-4 text-xs font-semibold text-emerald-400 uppercase mb-2">Pengaturan</p>

        <a href="#" class="flex items-center px-4 py-3 rounded-lg text-emerald-100 hover:bg-emerald-800 hover:text-white transition-colors">
            <i class="fas fa-truck w-6"></i>
            <span class="font-medium">Ongkos Kirim</span>
        </a>
    </nav>

    <div class="p-4 border-t border-emerald-800 bg-emerald-900">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-emerald-700 flex items-center justify-center text-white border-2 border-emerald-500">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="overflow-hidden">
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