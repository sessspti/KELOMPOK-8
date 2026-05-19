<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Atur Ulang Kata Sandi - FoodSave</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
        }

        /* Custom Swiper Pagination Color */
        .swiper-pagination-bullet {
            background: rgba(255, 255, 255, 0.5) !important;
            width: 10px !important;
            height: 10px !important;
        }

        .swiper-pagination-bullet-active {
            background: #facc15 !important;
            /* text-yellow-400 */
        }
        .swiper {
            width: 100%;
            height: 100%;
        }
        .swiper-slide {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body class="antialiased bg-gray-50 text-gray-800 selection:bg-green-500 selection:text-white">
    <div class="min-h-screen flex">

        <!-- Left Side: Image/Branding -->
        <div class="hidden lg:flex lg:w-1/2 relative items-center justify-center overflow-hidden bg-green-900">
            <!-- Swiper Background -->
            <div class="swiper mySwiper" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 100%; z-index: 0;">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><img src="{{ asset('images/slider/slide1.jpg') }}" class="w-full h-full object-cover" alt="FoodSave Slide 1"></div>
                    <div class="swiper-slide"><img src="{{ asset('images/slider/slide2.jpg') }}" class="w-full h-full object-cover" alt="FoodSave Slide 2"></div>
                    <div class="swiper-slide"><img src="{{ asset('images/slider/slide3.jpg') }}" class="w-full h-full object-cover" alt="FoodSave Slide 3"></div>
                </div>
            </div>

            <!-- Overlay Gradients -->
            <div class="absolute inset-0 bg-green-900/70 mix-blend-multiply z-10 pointer-events-none"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-green-900 via-green-900/60 to-transparent z-10 pointer-events-none"></div>
            
            <!-- Branding Content -->
            <div class="relative z-50 text-center px-12 text-white pointer-events-none" style="text-shadow: 0 4px 8px rgba(0,0,0,0.5);">
                <h1 class="text-6xl font-bold mb-4 tracking-tight text-white">Food<span class="text-yellow-400">Save</span></h1>
                
                <div class="h-16 flex items-center justify-center transition-opacity duration-300" id="dynamicTextContainer">
                    <p class="text-xl font-medium text-green-50 leading-relaxed max-w-lg mx-auto" id="dynamicText">
                        Membantu menyalurkan makanan berlebih ke tangan yang tepat.
                    </p>
                </div>

                <p class="text-lg font-light text-yellow-300 mt-4 max-w-lg mx-auto">
                    Ayo bergabung bersama kami di website FoodSave
                </p>
                <div class="mt-8">
                    <div class="swiper-pagination relative !bottom-0 pointer-events-auto"></div>
                </div>
            </div>
        </div>

        <!-- Right Side: Reset Password Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gradient-to-br from-green-50 to-yellow-50/50">
            <div class="w-full max-w-md glass-panel p-10 rounded-3xl shadow-xl border border-white/60">

                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <h1 class="text-4xl font-bold tracking-tight text-green-800">Food<span class="text-yellow-500">Save</span></h1>
                </div>

                <div class="mb-8 text-center lg:text-left">
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">Atur Ulang <span class="text-green-700">Kata</span> <span class="text-yellow-500">Sandi</span></h2>
                    <p class="text-gray-500 text-sm">
                        Silakan buat kata sandi baru yang kuat untuk mengamankan akun Anda.
                    </p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required readonly
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 outline-none shadow-sm cursor-not-allowed">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" autofocus
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring focus:ring-green-500/20 transition-all duration-200 outline-none bg-white shadow-sm"
                            placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring focus:ring-green-500/20 transition-all duration-200 outline-none bg-white shadow-sm"
                            placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-xs" />
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-xl shadow-md text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:-translate-y-0.5">
                            Simpan Kata Sandi Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const sliderTexts = [
            "Membantu menyalurkan makanan berlebih ke tangan yang tepat.",
            "Langkah kecil selamatkan bumi dengan mengurangi limbah makanan.",
            "Berbagi kebaikan, nikmati manfaatnya bersama komunitas."
        ];
        const textContainer = document.getElementById('dynamicTextContainer');
        const textElement = document.getElementById('dynamicText');

        var swiper = new Swiper(".mySwiper", {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            grabCursor: true,
            effect: "fade",
            fadeEffect: {
                crossFade: true
            },
            on: {
                slideChange: function () {
                    if (textContainer && textElement) {
                        textContainer.style.opacity = 0;
                        setTimeout(() => {
                            textElement.innerText = sliderTexts[this.realIndex];
                            textContainer.style.opacity = 1;
                        }, 300);
                    }
                }
            }
        });

        // Show Error Alert if there are validation errors
        @if ($errors->any())
            Swal.fire({
                title: "Eror!",
                text: "Terjadi kesalahan. Pastikan kata sandi memenuhi kriteria dan konfirmasi cocok.",
                icon: "error",
                confirmButtonColor: "#16a34a",
            });
        @endif
    </script>
</body>

</html>

