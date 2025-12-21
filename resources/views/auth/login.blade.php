<x-guest-layout>
    <div class="mb-8">
        <h3 class="text-3xl font-serif font-bold text-[#2E4F38] mb-2">Selamat Datang Kembali</h3>
        <p class="text-gray-500">Masuk untuk mengelola pesanan dan akun Anda.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-600 font-bold" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl px-4 py-3" 
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-600 font-bold" />
            <x-text-input id="password" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl px-4 py-3"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500" name="remember">
                <span class="ms-2 text-sm text-gray-500 group-hover:text-emerald-600 transition-colors">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <button type="submit" class="w-full bg-[#4CAF50] hover:bg-emerald-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-emerald-200 transition-all transform hover:-translate-y-0.5 mt-2">
            {{ __('Masuk Sekarang') }}
        </button>

        <p class="text-center text-sm text-gray-500 mt-6">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="font-bold text-[#4CAF50] hover:text-emerald-700 hover:underline">
                Daftar Gratis
            </a>
        </p>
    </form>
</x-guest-layout>
