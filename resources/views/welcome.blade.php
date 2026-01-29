<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'ABCSHOP') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('icon-512.png') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 flex flex-col items-center justify-center min-h-screen p-6">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 text-center">
            <img src="{{ asset('icon-512.png') }}" class="h-24 w-auto mx-auto mb-6" alt="Logo">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ config('app.name') }}</h1>
            <p class="text-gray-600 mb-8">Premium E-commerce Shopping Experience</p>
            
            <div class="space-y-4">
                <a href="{{ route('shop.index') }}" class="block w-full py-3 px-6 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition duration-200">
                    Visit Shop
                </a>
                
                @if (Route::has('login'))
                    <div class="flex gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="flex-1 py-3 px-6 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition duration-200">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="flex-1 py-3 px-6 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition duration-200">
                                Log in
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
        <footer class="mt-8 text-gray-400 text-sm">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </footer>
    </body>
</html>
