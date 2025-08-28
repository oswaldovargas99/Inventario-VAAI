<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <meta name="color-scheme" content="light dark">
        <script>
            (() => {
                const ls = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (ls === 'dark' || (!ls && prefersDark)) {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Vite / Livewire styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            {{-- Aquí se insertará el contenido --}}
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')
        @livewireScripts
        @livewireNavigateScripts

        @if(session('success'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 5000)" {{-- Duración más razonable (5 segundos) --}}
                class="fixed top-4 right-4 z-50 px-4 py-2 bg-green-600 text-white rounded-lg shadow-lg">
                {{ session('success') }}
            </div>
        @endif
    </body>
</html>
