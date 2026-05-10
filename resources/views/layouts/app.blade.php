<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FoodSave') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            :root {
                --mint-50:  #f0fdf6;
                --mint-100: #dcfce9;
                --mint-200: #bbf7d4;
                --mint-300: #86efb0;
                --mint-400: #4ade80;
                --mint-500: #22c55e;
                --mint-600: #16a34a;
                --mint-700: #15803d;
                --green-800: #166534;
                --green-900: #14532d;
                --ink: #111917;
                --white: #ffffff;
                --off-white: #f7fdf9;
                --border: rgba(22,163,74,0.15);
                --r-pill: 999px;
            }

            body { 
                font-family: 'Outfit', sans-serif; 
                background: var(--off-white);
                color: var(--ink);
                overflow-x: hidden;
            }

            /* ─── HEADER SHARED ─── */
            .hdr {
                position: sticky;
                top: 0;
                z-index: 100;
                background: rgba(247,253,249,0.88);
                backdrop-filter: blur(20px);
                border-bottom: 1.5px solid var(--border);
            }
            .hdr-inner {
                max-width: 1380px;
                margin: 0 auto;
                padding: 0 2rem;
                height: 70px;
                display: flex;
                align-items: center;
                gap: 1.5rem;
            }
            .logo {
                font-weight: 700;
                font-size: 1.4rem;
                color: var(--ink);
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 12px;
            }
            .logo-text-save { color: var(--mint-600); }

            .hdr-search { flex: 1; max-width: 420px; position: relative; display: none; }
            @media(min-width:768px){.hdr-search{display:block}}
            .hdr-search input {
                width: 100%;
                background: var(--mint-50);
                border: 1.5px solid var(--border);
                border-radius: var(--r-pill);
                padding: 0.6rem 1.1rem 0.6rem 2.8rem;
                font-size: 0.875rem;
                outline: none;
                transition: all 0.2s;
            }
            .hdr-search input:focus { border-color: var(--mint-400); background: #fff; }
            .hdr-search-ico { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #8aab9a; width: 15px; height: 15px; }

            .hdr-right { margin-left: auto; display: flex; align-items: center; gap: 0.75rem; }
            .pts-pill {
                background: #fde047;
                color: #78350f;
                font-weight: 700;
                font-size: 0.8125rem;
                padding: 0.45rem 1.1rem;
                border-radius: var(--r-pill);
                border: 2px solid rgba(0,0,0,0.08);
            }
        </style>
    </head>
    <body class="antialiased bg-gray-50 text-gray-800 selection:bg-green-500 selection:text-white">
        <div class="min-h-screen bg-gray-50">
            
            {{-- 
                Navigasi dan Header bawaan Laravel sengaja dihapus 
                agar tidak menutupi Header FoodSave buatan Septiana.
            --}}

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>