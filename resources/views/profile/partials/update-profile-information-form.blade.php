<section>
    <header>
        <h2 class="text-2xl font-bold text-green-800">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-2 text-sm text-gray-500">
            {{ __("Perbarui informasi profil dan alamat email akun Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Picture Avatar -->
        <div class="flex items-center gap-6 pb-2">
            <div class="relative group">
                <div class="h-24 w-24 rounded-full bg-gradient-to-tr from-green-100 to-yellow-50 flex items-center justify-center border-4 border-white shadow-lg overflow-hidden shrink-0 transition-transform duration-300 group-hover:scale-105">
                    @if(Auth::user()->avatar)
                        <img id="avatar-preview" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile Avatar" class="h-full w-full object-cover">
                    @else
                        <img id="avatar-preview" src="{{ asset('storage/avatars/default.png') }}" style="display:none;" alt="Profile Avatar" class="h-full w-full object-cover">
                        <span id="avatar-initials" class="text-3xl font-bold text-green-700">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    @endif
                </div>
                <div class="absolute inset-0 bg-black bg-opacity-40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer" onclick="document.getElementById('avatar').click()">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
            </div>
            <div>
                <input type="file" name="avatar" id="avatar" class="hidden" accept="image/jpeg,image/png,image/jpg" onchange="previewImage(event)">
                <button type="button" onclick="document.getElementById('avatar').click()" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-green-700 hover:border-green-200 transition-all duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1">
                    Ubah Foto Profil
                </button>
                <p class="mt-2 text-xs text-gray-500">Format JPG, JPEG, atau PNG. Maksimal 2MB.</p>
                <x-input-error class="mt-2 text-red-500 text-xs" :messages="$errors->get('avatar')" />
            </div>
        </div>

        <script>
            function previewImage(event) {
                const reader = new FileReader();
                reader.onload = function(){
                    const output = document.getElementById('avatar-preview');
                    const initials = document.getElementById('avatar-initials');
                    if (output) {
                        output.src = reader.result;
                        output.style.display = 'block';
                    }
                    if (initials) {
                        initials.style.display = 'none';
                    }
                };
                if(event.target.files[0]) {
                    reader.readAsDataURL(event.target.files[0]);
                }
            }
        </script>

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" 
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring focus:ring-green-500/20 transition-all duration-200 outline-none bg-white shadow-sm" />
            <x-input-error class="mt-2 text-red-500 text-xs" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" 
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring focus:ring-green-500/20 transition-all duration-200 outline-none bg-white shadow-sm" />
            <x-input-error class="mt-2 text-red-500 text-xs" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 bg-yellow-50 p-4 rounded-xl border border-yellow-100">
                    <p class="text-sm text-yellow-800">
                        {{ __('Alamat email Anda belum terverifikasi.') }}

                        <button form="send-verification" class="underline text-sm text-yellow-600 hover:text-yellow-900 font-medium">
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

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-xl shadow-md text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:-translate-y-0.5">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
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
