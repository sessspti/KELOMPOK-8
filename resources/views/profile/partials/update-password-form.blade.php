<section>
    <header>
        <h2 class="text-2xl font-bold text-green-800">
            {{ __('Perbarui Kata Sandi') }}
        </h2>

        <p class="mt-2 text-sm text-gray-500">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" 
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring focus:ring-green-500/20 transition-all duration-200 outline-none bg-white shadow-sm" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-500 text-xs" />
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password" 
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring focus:ring-green-500/20 transition-all duration-200 outline-none bg-white shadow-sm" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-500 text-xs" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi Baru</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" 
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring focus:ring-green-500/20 transition-all duration-200 outline-none bg-white shadow-sm" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-500 text-xs" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-xl shadow-md text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:-translate-y-0.5">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium flex items-center bg-green-50 px-3 py-1 rounded-full border border-green-100"
                >
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ __('Tersimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>
