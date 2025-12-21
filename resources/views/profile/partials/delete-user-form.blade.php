<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-slate-800">
            Hapus Akun
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Sebelum menghapus akun, harap unduh data atau informasi apa pun yang ingin Anda simpan.
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-500 text-white font-bold py-2.5 px-6 rounded-xl hover:bg-red-600 transition-colors shadow-lg shadow-red-200"
    >{{ __('Hapus Akun') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-slate-900">
                {{ __('Apakah Anda yakin ingin menghapus akun Anda?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                {{ __('Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">Password</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 border-gray-300 rounded-xl shadow-sm focus:border-red-500 focus:ring focus:ring-red-500/20 py-2.5 px-4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-bold transition-colors">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 font-bold transition-colors shadow-md shadow-red-200">
                    {{ __('Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
