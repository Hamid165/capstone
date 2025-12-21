<section>
    <header>
        <h2 class="text-lg font-bold text-slate-800">
            Perbarui Password
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block font-bold text-sm text-slate-700 mb-1">Password Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" class="w-full border-gray-300 rounded-xl shadow-sm focus:border-[#4CAF50] focus:ring focus:ring-[#4CAF50]/20 transition-all font-medium py-2.5 px-4" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="block font-bold text-sm text-slate-700 mb-1">Password Baru</label>
            <input id="update_password_password" name="password" type="password" class="w-full border-gray-300 rounded-xl shadow-sm focus:border-[#4CAF50] focus:ring focus:ring-[#4CAF50]/20 transition-all font-medium py-2.5 px-4" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block font-bold text-sm text-slate-700 mb-1">Konfirmasi Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full border-gray-300 rounded-xl shadow-sm focus:border-[#4CAF50] focus:ring focus:ring-[#4CAF50]/20 transition-all font-medium py-2.5 px-4" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-[#4CAF50] text-white font-bold py-2.5 px-6 rounded-xl hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-200">
                {{ __('Simpan Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-600 font-bold flex items-center gap-1"
                ><i class="fas fa-check-circle"></i> {{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
