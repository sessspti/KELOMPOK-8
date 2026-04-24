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
            body { 
                font-family: 'Outfit', sans-serif; 
            }
            /* Menghilangkan scrollbar horizontal jika ada */
            body {
                overflow-x: hidden;
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