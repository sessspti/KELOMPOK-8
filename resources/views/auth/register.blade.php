<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Daftar - FoodSave</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .bg-food-pattern {
            background-image: url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1974&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800 selection:bg-green-500 selection:text-white">
    <div class="min-h-screen flex">
        
        <div class="hidden lg:flex lg:w-1/2 bg-food-pattern relative items-center justify-center">
            <div class="absolute inset-0 bg-green-900/70 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-green-900 via-green-900/60 to-transparent"></div>
            
            <div class="relative z-10 text-center px-12 text-white">
                <h1 class="text-6xl font-bold mb-6 tracking-tight drop-shadow-lg">Food<span class="text-yellow-400">Save</span></h1>
                <p class="text-2xl font-light text-green-50 leading-relaxed max-w-lg mx-auto">
                    Ayo bergabung bersama kami.
                </p>
                <div class="mt-12 flex justify-center gap-4">
                    <div class="h-1 w-12 bg-yellow-400 rounded-full"></div>
                    <div class="h-1 w-4 bg-green-400 rounded-full"></div>
                    <div class="h-1 w-4 bg-green-400 rounded-full"></div>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gradient-to-br from-green-50 to-yellow-50/50 min-h-screen overflow-y-auto">
            <div class="w-full max-w-md glass-panel p-10 rounded-3xl shadow-xl border border-white/60 my-8">
                
                <div class="lg:hidden text-center mb-8">
                    <h1 class="text-4xl font-bold tracking-tight text-green-800">Food<span class="text-yellow-500">Save</span></h1>
                </div>

                <div class="mb-10 text-center lg:text-left">
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">Buat Akun Baru</h2>
                    <p class="text-gray-500 text-sm">Lengkapi data Anda di bawah ini untuk mendaftar.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring focus:ring-green-500/20 transition-all duration-200 outline-none bg-white shadow-sm" 
                            placeholder="Contoh: Jokowi">
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-xs" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring focus:ring-green-500/20 transition-all duration-200 outline-none bg-white shadow-sm" 
                            placeholder="ana@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Daftar Sebagai</label>
                        <select id="role" name="role" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring focus:ring-green-500/20 transition-all duration-200 outline-none bg-white shadow-sm">
                            <option value="" disabled selected>-- Pilih Peran Akun --</option>
                            <option value="konsumen_seller">Seller</option>
                            <option value="konsumen_seller">Konsumen</option>
                            <option value="lembaga_sosial">Lembaga Sosial</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2 text-red-500 text-xs" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" 
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring focus:ring-green-500/20 transition-all duration-200 outline-none bg-white shadow-sm" 
                            placeholder="Minimal 8 karakter">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring focus:ring-green-500/20 transition-all duration-200 outline-none bg-white shadow-sm" 
                            placeholder="Ulangi kata sandi">
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-xl shadow-md text-sm font-medium text-white bg-green-600 hover:bg-green-700 transition-all duration-200 transform hover:-translate-y-0.5">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-300"></div></div>
                        <div class="relative flex justify-center text-sm"><span class="px-2 bg-white text-gray-500">Atau daftar dengan</span></div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('social.redirect', 'google') }}" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                            Google
                        </a>
                    </div>
                </div>

                <div class="mt-8 text-center text-sm text-gray-500">
                    Sudah punya akun? <a href="{{ route('login') }}" class="font-medium text-yellow-600 hover:text-yellow-500">Masuk di sini</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>