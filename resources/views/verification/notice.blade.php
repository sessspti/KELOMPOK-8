<x-app-layout>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Hanken+Grotesk:ital,wght@0,300;0,400;0,500;0,700;0,900;1,400&display=swap" rel="stylesheet">
    
    <style>
        .custom-font-hanken {
            font-family: 'Hanken Grotesk', sans-serif;
        }
        .custom-font-space {
            font-family: 'Space Grotesk', sans-serif;
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.95; transform: scale(0.995); }
        }
        .animate-pulse-slow {
            animation: pulse-slow 3s ease-in-out infinite;
        }
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 8s linear infinite;
        }
        @keyframes bounce-short {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }
        .animate-bounce-short {
            animation: bounce-short 2s ease-in-out infinite;
        }
    </style>

    <div class="py-12 custom-font-hanken bg-gray-50/50 min-height-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-100 rounded-3xl shadow-xl overflow-hidden">
                <div class="p-8 sm:p-10 text-gray-900">
                    
                    <!-- Header Section -->
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 border-b border-gray-100 pb-6 mb-8">
                        <div>
                            <span class="text-xs font-bold text-green-600 uppercase tracking-widest custom-font-space">Verifikasi Keamanan</span>
                            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900 mt-1 custom-font-space">Verifikasi Pendaftaran</h2>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 bg-red-50 text-red-600 border border-red-100 hover:bg-red-100 hover:border-red-200 px-5 py-2.5 rounded-2xl font-bold text-sm cursor-pointer transition-all duration-200 shadow-sm hover:shadow active:scale-95">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Keluar Akun
                            </button>
                        </form>
                    </div>

                    @if(session('success'))
                        <div class="mb-6 p-4 text-green-700 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-sm font-semibold">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Account Status Banner -->
                    @if($user->account_status === 'approved')
                        <div class="mb-8 p-6 bg-green-50 border border-green-200 rounded-2xl flex items-start gap-4 shadow-sm">
                            <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-green-850 custom-font-space">Akun Berhasil Diverifikasi!</h4>
                                <p class="text-sm text-green-700 mt-1">Selamat, akun Anda telah aktif dan disetujui untuk beraktivitas di platform FoodSave.</p>
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 mt-4 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md hover:shadow-lg active:scale-95">
                                    Lanjut ke Dashboard
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>
                        </div>
                    @elseif($user->account_status === 'pending' && $verification)
                        <div class="mb-8 p-6 bg-amber-50 border border-amber-200 rounded-2xl flex items-start gap-4 shadow-sm animate-pulse-slow">
                            <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H17.2"/></svg>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-amber-800 custom-font-space">Menunggu Persetujuan Admin</h4>
                                <p class="text-sm text-amber-700 mt-1">Dokumen Anda sedang dalam proses peninjauan oleh tim admin FoodSave. Kami akan segera memberi tahu Anda setelah proses verifikasi selesai. Silakan periksa kembali halaman ini secara berkala.</p>
                            </div>
                        </div>
                    @elseif($user->account_status === 'rejected')
                        <div class="mb-8 p-6 bg-red-50/70 border border-red-200 rounded-2xl flex items-start gap-4 shadow-sm">
                            <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0 animate-bounce-short">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-red-800 custom-font-space">Pendaftaran Ditolak</h4>
                                <p class="text-sm text-red-700 mt-1">
                                    <span class="font-bold">Alasan Penolakan:</span> {{ $verification->rejection_reason ?? 'Dokumen yang diunggah tidak valid atau tidak terbaca.' }}
                                </p>
                                <p class="text-sm text-red-600 mt-2 font-medium">Silakan perbaiki data dan unggah kembali dokumen pendukung yang sesuai di bawah ini.</p>
                            </div>
                        </div>
                    @else
                        <div class="mb-8 p-6 bg-blue-50 border border-blue-200 rounded-2xl flex items-start gap-4 shadow-sm">
                            <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-blue-800 custom-font-space">Langkah Terakhir Pendaftaran</h4>
                                <p class="text-sm text-blue-700 mt-1">Untuk menjaga keamanan dan keaslian ekosistem FoodSave, kami membutuhkan beberapa informasi dasar serta dokumen legalitas Anda. Mohon lengkapi formulir di bawah ini dengan data yang valid.</p>
                            </div>
                        </div>
                    @endif

                    @if(!$verification || $user->account_status === 'rejected')
                        <form id="verificationForm" action="{{ route('verification.upload') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            
                            <!-- 1. Informasi Dasar -->
                            <div class="bg-green-50/20 p-6 sm:p-8 rounded-3xl border border-green-100 mb-8 shadow-sm">
                                <h3 class="text-lg font-bold mb-6 text-green-800 flex items-center gap-2.5 custom-font-space">
                                    <span class="w-8 h-8 rounded-xl bg-green-100 text-green-700 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </span>
                                    Informasi Dasar
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-1">
                                        <label for="phone_number" class="block text-sm font-bold text-gray-700 mb-2">Nomor HP / WhatsApp <span class="text-red-550">*</span></label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                            </div>
                                            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required
                                                placeholder="Contoh: 08123456789"
                                                class="pl-12 block w-full text-sm text-gray-900 border border-green-200 rounded-2xl bg-white focus:ring-4 focus:ring-green-150 focus:border-green-500 p-4 shadow-sm transition-all hover:border-green-300 outline-none">
                                        </div>
                                        @error('phone_number') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="address" class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap Usaha/Lembaga <span class="text-red-555">*</span></label>
                                        <div class="relative">
                                            <textarea name="address" id="address" rows="3" required
                                                placeholder="Masukkan alamat lengkap operasional usaha atau lembaga sosial Anda..."
                                                class="block w-full text-sm text-gray-900 border border-green-200 rounded-2xl bg-white focus:ring-4 focus:ring-green-150 focus:border-green-500 p-4 shadow-sm transition-all hover:border-green-300 outline-none">{{ old('address', $user->address) }}</textarea>
                                        </div>
                                        @error('address') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Unggah Dokumen Pendukung -->
                            <div class="bg-blue-50/20 p-6 sm:p-8 rounded-3xl border border-blue-100 shadow-sm mb-8">
                                <h3 class="text-lg font-bold mb-6 text-blue-800 flex items-center gap-2.5 custom-font-space">
                                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </span>
                                    Unggah Dokumen Pendukung
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    
                                    <!-- Card KTP -->
                                    <div class="relative bg-white rounded-2xl border-2 border-dashed border-gray-200 hover:border-blue-500 p-6 transition-all duration-200 cursor-pointer flex flex-col items-center justify-center text-center hover:bg-blue-50/10 group min-h-[220px]"
                                         id="ktp-zone" onclick="document.getElementById('ktp').click()">
                                        <input type="file" name="ktp" id="ktp" accept=".pdf,.jpg,.jpeg,.png" required class="hidden" onchange="updateFilePreview(this, 'ktp-preview')">
                                        <div id="ktp-preview" class="flex flex-col items-center w-full">
                                            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-200 shadow-sm">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                            </div>
                                            <span class="text-sm font-bold text-gray-800">Scan KTP Pemilik <span class="text-red-500">*</span></span>
                                            <span class="text-xs text-gray-500 mt-1 px-4">Klik atau seret file dokumen KTP di sini</span>
                                            <span class="text-[10px] text-gray-400 mt-2 bg-gray-50 px-2.5 py-1 rounded-full border border-gray-100">PDF, PNG, JPG (Maks. 2MB)</span>
                                        </div>
                                        @error('ktp') <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                                    </div>

                                    <!-- Card NIB -->
                                    <div class="relative bg-white rounded-2xl border-2 border-dashed border-gray-200 hover:border-blue-500 p-6 transition-all duration-200 cursor-pointer flex flex-col items-center justify-center text-center hover:bg-blue-50/10 group min-h-[220px]"
                                         id="nib-zone" onclick="document.getElementById('nib').click()">
                                        <input type="file" name="nib" id="nib" accept=".pdf,.jpg,.jpeg,.png" class="hidden" onchange="updateFilePreview(this, 'nib-preview')">
                                        <div id="nib-preview" class="flex flex-col items-center w-full">
                                            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-200 shadow-sm">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </div>
                                            <span class="text-sm font-bold text-gray-800">Scan NIB <span class="text-gray-400 font-normal text-xs">(Opsional)</span></span>
                                            <span class="text-xs text-gray-500 mt-1 px-4">Nomor Induk Berusaha</span>
                                            <span class="text-[10px] text-gray-400 mt-2 bg-gray-50 px-2.5 py-1 rounded-full border border-gray-100">PDF, PNG, JPG (Maks. 2MB)</span>
                                        </div>
                                        @error('nib') <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                                    </div>

                                    <!-- Card Surat Izin -->
                                    <div class="relative bg-white rounded-2xl border-2 border-dashed border-gray-200 hover:border-blue-500 p-6 transition-all duration-200 cursor-pointer flex flex-col items-center justify-center text-center hover:bg-blue-50/10 group min-h-[220px]"
                                         id="surat_izin-zone" onclick="document.getElementById('surat_izin').click()">
                                        <input type="file" name="surat_izin" id="surat_izin" accept=".pdf,.jpg,.jpeg,.png" class="hidden" onchange="updateFilePreview(this, 'surat_izin-preview')">
                                        <div id="surat_izin-preview" class="flex flex-col items-center w-full">
                                            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-200 shadow-sm">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                            </div>
                                            <span class="text-sm font-bold text-gray-800">Surat Izin Usaha / Lembaga <span class="text-gray-400 font-normal text-xs">(Opsional)</span></span>
                                            <span class="text-xs text-gray-500 mt-1 px-4">Surat Izin Operasional Resmi</span>
                                            <span class="text-[10px] text-gray-400 mt-2 bg-gray-50 px-2.5 py-1 rounded-full border border-gray-100">PDF, PNG, JPG (Maks. 2MB)</span>
                                        </div>
                                        @error('surat_izin') <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                                    </div>

                                    <!-- Card Profil / Portofolio -->
                                    <div class="relative bg-white rounded-2xl border-2 border-dashed border-gray-200 hover:border-blue-500 p-6 transition-all duration-200 cursor-pointer flex flex-col items-center justify-center text-center hover:bg-blue-50/10 group min-h-[220px]"
                                         id="profil_seller-zone" onclick="document.getElementById('profil_seller').click()">
                                        <input type="file" name="profil_seller" id="profil_seller" accept=".pdf,.jpg,.jpeg,.png" class="hidden" onchange="updateFilePreview(this, 'profil_seller-preview')">
                                        <div id="profil_seller-preview" class="flex flex-col items-center w-full">
                                            <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-200 shadow-sm">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                            <span class="text-sm font-bold text-gray-800">Brosur / Portofolio Usaha <span class="text-gray-400 font-normal text-xs">(Opsional)</span></span>
                                            <span class="text-xs text-gray-500 mt-1 px-4">Profil atau Dokumentasi Kegiatan</span>
                                            <span class="text-[10px] text-gray-400 mt-2 bg-gray-50 px-2.5 py-1 rounded-full border border-gray-100">PDF, PNG, JPG (Maks. 2MB)</span>
                                        </div>
                                        @error('profil_seller') <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                                    </div>

                                </div>
                            </div>
                            
                            <!-- Submit Area -->
                            <div class="flex items-center justify-end mt-10">
                                <button type="button" onclick="confirmSubmit()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-10 py-4 bg-green-600 hover:bg-green-700 border border-transparent rounded-2xl font-bold text-base text-white hover:shadow-green shadow-md active:scale-98 transition-all duration-200 transform cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                    Kirim Berkas Verifikasi
                                </button>
                            </div>
                        </form>

                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                            function updateFilePreview(input, previewId) {
                                const container = document.getElementById(previewId);
                                if (input.files && input.files[0]) {
                                    const file = input.files[0];
                                    const fileName = file.name;
                                    const fileSize = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
                                    const fileType = file.type;
                                    
                                    let iconHtml = '';
                                    if (fileType.includes('image')) {
                                        iconHtml = `
                                            <div class="w-14 h-14 rounded-2xl overflow-hidden bg-gray-50 mb-3 border border-gray-200 shadow-sm flex items-center justify-center">
                                                <img src="${URL.createObjectURL(file)}" class="w-full h-full object-cover">
                                            </div>
                                        `;
                                    } else {
                                        iconHtml = `
                                            <div class="w-14 h-14 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center mb-3 shadow-sm border border-red-100">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                            </div>
                                        `;
                                    }
                                    
                                    container.innerHTML = `
                                        ${iconHtml}
                                        <span class="text-sm font-bold text-gray-800 break-all max-w-[220px] px-4 text-center leading-snug">${fileName}</span>
                                        <span class="text-xs text-gray-400 mt-1">${fileSize}</span>
                                        <button type="button" class="mt-4 text-xs font-bold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-4 py-1.5 rounded-xl transition-all shadow-sm" onclick="event.stopPropagation(); clearFileInput('${input.id}', '${previewId}')">
                                            Hapus Berkas
                                        </button>
                                    `;
                                }
                            }

                            function clearFileInput(inputId, previewId) {
                                const input = document.getElementById(inputId);
                                input.value = '';
                                
                                const labels = {
                                    'ktp': { title: 'Scan KTP Pemilik <span class="text-red-550">*</span>', color: 'blue', text: 'Klik atau seret file dokumen KTP di sini', icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>' },
                                    'nib': { title: 'Scan NIB <span class="text-gray-400 font-normal text-xs">(Opsional)</span>', color: 'indigo', text: 'Nomor Induk Berusaha', icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>' },
                                    'surat_izin': { title: 'Surat Izin Usaha / Lembaga <span class="text-gray-400 font-normal text-xs">(Opsional)</span>', color: 'emerald', text: 'Surat Izin Operasional Resmi', icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>' },
                                    'profil_seller': { title: 'Brosur / Portofolio Usaha <span class="text-gray-400 font-normal text-xs">(Opsional)</span>', color: 'amber', text: 'Profil atau Dokumentasi Kegiatan', icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>' }
                                };
                                
                                const item = labels[inputId];
                                const container = document.getElementById(previewId);
                                
                                container.innerHTML = `
                                    <div class="w-14 h-14 rounded-2xl bg-${item.color}-50 text-${item.color}-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-200 shadow-sm">
                                        ${item.icon}
                                    </div>
                                    <span class="text-sm font-bold text-gray-800">${item.title}</span>
                                    <span class="text-xs text-gray-500 mt-1 px-4">${item.text}</span>
                                    <span class="text-[10px] text-gray-400 mt-2 bg-gray-50 px-2.5 py-1 rounded-full border border-gray-100">PDF, PNG, JPG (Maks. 2MB)</span>
                                `;
                            }

                            document.addEventListener("DOMContentLoaded", function() {
                                const dropzones = ['ktp', 'nib', 'surat_izin', 'profil_seller'];
                                dropzones.forEach(id => {
                                    const zone = document.getElementById(id + '-zone');
                                    const input = document.getElementById(id);
                                    if (!zone || !input) return;
                                    
                                    ['dragenter', 'dragover'].forEach(eventName => {
                                        zone.addEventListener(eventName, (e) => {
                                            e.preventDefault();
                                            e.stopPropagation();
                                            zone.classList.add('border-blue-500', 'bg-blue-50/10');
                                        }, false);
                                    });

                                    ['dragleave', 'drop'].forEach(eventName => {
                                        zone.addEventListener(eventName, (e) => {
                                            e.preventDefault();
                                            e.stopPropagation();
                                            zone.classList.remove('border-blue-500', 'bg-blue-50/10');
                                        }, false);
                                    });

                                    zone.addEventListener('drop', (e) => {
                                        const dt = e.dataTransfer;
                                        const files = dt.files;
                                        if (files.length) {
                                            input.files = files;
                                            updateFilePreview(input, id + '-preview');
                                        }
                                    }, false);
                                });
                            });

                            function confirmSubmit() {
                                const form = document.getElementById('verificationForm');
                                const phone = document.getElementById('phone_number').value;
                                const address = document.getElementById('address').value;
                                const ktp = document.getElementById('ktp').value;

                                if(!phone || !address || !ktp) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Data Belum Lengkap',
                                        text: 'Mohon lengkapi Nomor HP, Alamat, dan unggah KTP Anda sebelum mengirim.',
                                        confirmButtonColor: '#22c55e',
                                        customClass: {
                                            popup: 'rounded-3xl border border-gray-100 shadow-xl'
                                        }
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
                                        popup: 'rounded-3xl border border-gray-100 shadow-xl',
                                        confirmButton: 'px-5 py-2.5 rounded-xl font-bold text-sm',
                                        cancelButton: 'px-5 py-2.5 rounded-xl font-bold text-sm'
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
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

                            @if($user->account_status === 'rejected')
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Akun Ditangguhkan',
                                    text: '{{ $verification->rejection_reason ?? "Mohon unggah kembali dokumen verifikasi Anda dengan data yang benar." }}',
                                    confirmButtonColor: '#ef4444',
                                    confirmButtonText: 'Mengerti',
                                    customClass: {
                                        popup: 'rounded-3xl border border-gray-100 shadow-xl'
                                    }
                                });
                            });
                            @endif
                        </script>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
