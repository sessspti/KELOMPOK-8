<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold">Verifikasi Pendaftaran</h2>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-1.5 bg-red-100 text-red-600 border border-red-200 px-4 py-1.5 rounded-full font-bold text-sm cursor-pointer transition-all duration-200 hover:bg-red-200 hover:border-red-300">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($user->account_status === 'approved')
                        <div class="mb-4 p-4 text-blue-700 bg-blue-100 rounded-lg">
                            Akun Anda telah disetujui. <a href="{{ route('dashboard') }}" class="underline font-bold">Lanjut ke Dashboard</a>
                        </div>
                    @elseif($user->account_status === 'pending' && $verification)
                        <div class="mb-4 p-4 text-yellow-800 bg-yellow-100 rounded-lg border border-yellow-200">
                            <strong>Menunggu Persetujuan Admin</strong><br>
                            Dokumen Anda sedang kami tinjau. Silakan tunggu beberapa saat hingga admin memberikan persetujuan.
                        </div>
                    @elseif($user->account_status === 'rejected')
                        <div class="mb-4 p-4 text-red-700 bg-red-100 rounded-lg border border-red-200">
                            <strong>Pendaftaran Ditolak</strong><br>
                            Alasan: {{ $verification->rejection_reason ?? 'Dokumen tidak valid.' }}<br>
                            Silakan unggah kembali dokumen yang sesuai.
                        </div>
                    @else
                        <div class="mb-4 p-4 text-blue-700 bg-blue-100 rounded-lg border border-blue-200">
                            <strong>Langkah Terakhir!</strong><br>
                            Untuk menjaga keamanan ekosistem FoodSave, silakan unggah dokumen verifikasi Anda (KTP/NIB/Surat Izin Lembaga) dalam format PDF/JPG/PNG maksimal 2MB.
                        </div>
                    @endif

                    @if(!$verification || $user->account_status === 'rejected')
                        <form id="verificationForm" action="{{ route('verification.upload') }}" method="POST" enctype="multipart/form-data" class="mt-6 border-t border-green-100 pt-8">
                            @csrf
                            
                            <div class="bg-green-50/50 p-6 rounded-xl border border-green-100 mb-8 shadow-sm">
                                <h3 class="text-lg font-bold mb-4 text-green-800 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Informasi Dasar
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">Nomor HP / WhatsApp <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                            </div>
                                            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required
                                                class="pl-10 block w-full text-sm text-gray-900 border border-green-200 rounded-lg bg-white focus:ring-green-500 focus:border-green-500 p-3 shadow-sm transition-all hover:border-green-300">
                                        </div>
                                        @error('phone_number') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap Usaha/Lembaga <span class="text-red-500">*</span></label>
                                        <textarea name="address" id="address" rows="3" required
                                            class="block w-full text-sm text-gray-900 border border-green-200 rounded-lg bg-white focus:ring-green-500 focus:border-green-500 p-3 shadow-sm transition-all hover:border-green-300">{{ old('address', $user->address) }}</textarea>
                                        @error('address') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="bg-blue-50/50 p-6 rounded-xl border border-blue-100 shadow-sm mb-6">
                                <h3 class="text-lg font-bold mb-4 text-blue-800 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Unggah Dokumen Pendukung
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:border-blue-300 transition-all">
                                        <label for="ktp" class="block text-sm font-bold text-gray-700 mb-2">Scan KTP Pemilik <span class="text-red-500">*</span></label>
                                        <input type="file" name="ktp" id="ktp" accept=".pdf,.jpg,.jpeg,.png" required
                                            class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer focus:outline-none">
                                        @error('ktp') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:border-blue-300 transition-all">
                                        <label for="nib" class="block text-sm font-bold text-gray-700 mb-2">Scan NIB <span class="text-gray-400 font-normal text-xs">(Opsional)</span></label>
                                        <input type="file" name="nib" id="nib" accept=".pdf,.jpg,.jpeg,.png"
                                            class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 cursor-pointer focus:outline-none">
                                        @error('nib') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:border-blue-300 transition-all">
                                        <label for="surat_izin" class="block text-sm font-bold text-gray-700 mb-2">Surat Izin Usaha / Lembaga <span class="text-gray-400 font-normal text-xs">(Opsional)</span></label>
                                        <input type="file" name="surat_izin" id="surat_izin" accept=".pdf,.jpg,.jpeg,.png"
                                            class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 cursor-pointer focus:outline-none">
                                        @error('surat_izin') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:border-blue-300 transition-all">
                                        <label for="profil_seller" class="block text-sm font-bold text-gray-700 mb-2">Profil Seller/Portofolio <span class="text-gray-400 font-normal text-xs">(Opsional)</span></label>
                                        <input type="file" name="profil_seller" id="profil_seller" accept=".pdf,.jpg,.jpeg,.png"
                                            class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 cursor-pointer focus:outline-none">
                                        @error('profil_seller') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-end mt-8">
                                <button type="button" onclick="confirmSubmit()" class="inline-flex items-center gap-2 px-8 py-3.5 bg-[#22c55e] border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-wider hover:bg-[#16a34a] focus:bg-[#16a34a] active:bg-[#15803d] focus:outline-none focus:ring-2 focus:ring-[#22c55e] focus:ring-offset-2 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                    Kirim Data & Dokumen
                                </button>
                            </div>
                        </form>

                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                            function confirmSubmit() {
                                // Basic validation check before SweetAlert
                                const form = document.getElementById('verificationForm');
                                const phone = document.getElementById('phone_number').value;
                                const address = document.getElementById('address').value;
                                const ktp = document.getElementById('ktp').value;

                                if(!phone || !address || !ktp) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Data Belum Lengkap',
                                        text: 'Mohon lengkapi Nomor HP, Alamat, dan unggah KTP Anda sebelum mengirim.',
                                        confirmButtonColor: '#22c55e'
                                    });
                                    return;
                                }

                                Swal.fire({
                                    title: 'Kirim Dokumen Verifikasi?',
                                    text: "Pastikan semua data dan dokumen yang Anda unggah sudah benar dan asli.",
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#22c55e',
                                    cancelButtonColor: '#ef4444',
                                    confirmButtonText: 'Ya, Kirim Sekarang!',
                                    cancelButtonText: 'Batal',
                                    customClass: {
                                        popup: 'rounded-2xl shadow-xl border border-gray-100',
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Show loading state
                                        Swal.fire({
                                            title: 'Mengunggah Data...',
                                            text: 'Mohon tunggu sebentar',
                                            allowOutsideClick: false,
                                            didOpen: () => {
                                                Swal.showLoading();
                                            }
                                        });
                                        form.submit();
                                    }
                                })
                            }
                        </script>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
