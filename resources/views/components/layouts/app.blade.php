{{-- resources/views/components/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Inventario UDG') }}</title>

  {{-- Dark-mode antes de CSS (anti-FOUC) --}}
  <meta name="color-scheme" content="light dark">
  <script>
    (() => {
      const ls = localStorage.getItem('theme');
      const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      if (ls === 'dark' || (!ls && prefersDark)) document.documentElement.classList.add('dark');
    })();
  </script>

  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>
<body
  x-data="{ dark: $persist(document.documentElement.classList.contains('dark')) }"
  x-init="$watch('dark', v => document.documentElement.classList.toggle('dark', v))"
  class="font-sans antialiased bg-gray-100 dark:bg-gray-900"
>
  <x-banner />

  <main>
    {{ $slot }}
  </main>

  @stack('modals')
  @livewireScripts
  @livewireNavigateScripts
</body>
</html>
