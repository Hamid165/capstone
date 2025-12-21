<x-guest-layout>
    <div class="mb-8">
        <h3 class="text-3xl font-serif font-bold text-[#2E4F38] mb-2">Buat Akun Baru</h3>
        <p class="text-gray-500">Bergabunglah dengan Dhawuh Bumi untuk menikmati sayuran segar.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-600 font-bold" />
            <x-text-input id="name" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl px-4 py-3" 
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-600 font-bold" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl px-4 py-3" 
                        type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-600 font-bold" />
            <x-text-input id="password" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl px-4 py-3"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-gray-600 font-bold" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl px-4 py-3"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="w-full bg-[#4CAF50] hover:bg-emerald-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-emerald-200 transition-all transform hover:-translate-y-0.5 mt-2">
            {{ __('Daftar Sekarang') }}
        </button>

        <p class="text-center text-sm text-gray-500 mt-6">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="font-bold text-[#4CAF50] hover:text-emerald-700 hover:underline">
                Masuk disini
            </a>
        </p>
    </form>
</x-guest-layout>
