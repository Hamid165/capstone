<section>
    <header>
        <h2 class="text-lg font-bold text-slate-800">
            Profil Anda
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Perbarui informasi profil akun dan alamat email Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block font-bold text-sm text-slate-700 mb-1">Nama Lengkap</label>
            <input id="name" name="name" type="text" class="w-full border-gray-300 rounded-xl shadow-sm focus:border-[#4CAF50] focus:ring focus:ring-[#4CAF50]/20 transition-all font-medium py-2.5 px-4" :value="old('name', $user->name)" required autofocus autocomplete="name" value="{{ old('name', $user->name) }}" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block font-bold text-sm text-slate-700 mb-1">Email Address</label>
            <input id="email" name="email" type="email" class="w-full border-gray-300 rounded-xl shadow-sm focus:border-[#4CAF50] focus:ring focus:ring-[#4CAF50]/20 transition-all font-medium py-2.5 px-4" :value="old('email', $user->email)" required autocomplete="username" value="{{ old('email', $user->email) }}" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-[#4CAF50] text-white font-bold py-2.5 px-6 rounded-xl hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-200">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
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
