<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ABCSHOP') }}</title>

        <!-- Scripts -->
        <link rel="icon" type="image/png" href="{{ asset('icon-512.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .auth-bg {
                background: linear-gradient(rgba(17, 24, 39, 0.4), rgba(17, 24, 39, 0.4)), url('/images/bg/login-bg.png');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
            .glass-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased selection:bg-indigo-100 selection:text-indigo-700">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 auth-bg">
            <div class="mb-8 transform hover:scale-105 transition-transform duration-300">
                <a href="/">
                    <x-application-logo class="w-24 h-24 fill-current text-white drop-shadow-2xl" />
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 glass-card shadow-2xl overflow-hidden sm:rounded-2xl border-t border-white/50">
                {{ $slot }}
            </div>

            <div class="mt-8 text-white/80 text-sm font-medium">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Built for performance.
            </div>
        </div>
    </body>
</html>

