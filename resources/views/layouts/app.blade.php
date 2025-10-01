<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Inventario UdG') }}</title>

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

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900" x-data="{ sidebarOpen: false }">

            @livewire('navigation-menu', ['sidebarOpen' => 'sidebarOpen'])
            
            {{-- ¡CAMBIO AQUÍ! 1. Forzamos la altura de este contenedor --}}
            <div class="flex h-[calc(100vh-4rem)]">
                
                {{-- ¡CAMBIO AQUÍ! 2. Añadimos scroll a la barra lateral por si su contenido crece --}}
                <nav class="flex-none w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 p-4 overflow-y-auto
                            fixed inset-y-0 left-0 z-50 transform
                            md:relative md:translate-x-0 transition-transform duration-300 ease-in-out
                            "
                     x-bind:class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">

                  <div class="p-4 font-bold text-lg text-gray-900 dark:text-gray-100 flex justify-between items-center md:hidden">
                    {{ config('app.name', 'Inventario UDG') }}
                    <button @click="sidebarOpen = false" class="text-gray-500 hover:text-gray-700">
                        <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                  </div>

                  <ul class="space-y-1 px-2 mt-4 md:mt-0">
                    @php $u = Auth::user(); @endphp

                    {{-- ===== Admin ===== --}}
                    @role('Admin')
                      <li>
                        <a href="{{ route('admin.dashboard') }}"
                           class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                           {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                          📊 Dashboard
                        </a>
                      </li>

                      <li>
                        <a href="{{ route('admin.users.index') }}"
                           class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                           {{ request()->routeIs('admin.users.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                          👥 Gestión de Usuarios
                        </a>
                      </li>
                      
                      <li>
                        <a href="{{ route('admin.dependencias.index') }}"
                           class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                           {{ request()->routeIs('admin.dependencias.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                          🏢 Dependencias
                        </a>
                      </li>

                      <li>
                        <a href="{{ route('admin.equipos.index') }}"
                          class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                          {{ request()->routeIs('admin.equipos.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                          📦 Inventario General
                        </a>
                      </li>

                      {{-- ===== Movimientos ===== --}}
                      @canany(['movimientos.view','movimientos.create','movimientos.edit','movimientos.delete','movimientos.approve'])
                        <li>
                          <a href="{{ route('admin.movimientos.index') }}"
                            class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                            {{ request()->routeIs('admin.movimientos.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                            🔄 Movimientos
                          </a>
                        </li>
                      @endcanany

                      <li>
                        <a href="{{ route('patrimonio.aprobaciones') }}"
                           class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                           {{ request()->routeIs('patrimonio.aprobaciones') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                          ✅ Aprobador
                        </a>
                      </li>

                      <li>
                        <a href="{{ route('secretaria.vobo') }}"
                           class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                           {{ request()->routeIs('secretaria.vobo') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                          📝 VoBo
                        </a>
                      </li>
                    @endrole

                    {{-- ===== Aprobador ===== --}}
                    @can('aprobar movimientos')
                      @unlessrole('Admin')
                        <li>
                          <a href="{{ route('panel') }}"
                             class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                             {{ request()->routeIs('panel') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                            📊 Dashboard
                          </a>
                        </li>
                        <li>
                          <a href="{{ route('admin.equipos.index') }}"
                             class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                             {{ request()->routeIs('admin.equipos.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                            📦 Inventario General
                          </a>
                        </li>
                        {{-- ===== Movimientos (Aprobador) ===== --}}
                        <li>
                          <a href="{{ route('admin.movimientos.index') }}"
                            class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                            {{ request()->routeIs('admin.movimientos.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                            🔄 Movimientos (Aprobar)
                          </a>
                        </li>
                        <li>
                          <a href="{{ route('patrimonio.aprobaciones') }}"
                             class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                             {{ request()->routeIs('patrimonio.aprobaciones') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                            ✅ Aprobador
                          </a>
                        </li>
                      @endunlessrole
                    @endcan

                    {{-- ===== VoBo ===== --}}
                    @can('vobo movimientos')
                      @unlessrole('Admin')
                        <li>
                          <a href="{{ route('panel') }}"
                             class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                             {{ request()->routeIs('panel') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                            📊 Dashboard
                          </a>
                        </li>
                        <li>
                          <a href="{{ route('admin.equipos.index') }}"
                             class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                             {{ request()->routeIs('admin.equipos.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                            📦 Inventario General
                          </a>
                        </li>
                        {{-- ===== Movimientos (VoBo) ===== --}}
                        <li>
                          <a href="{{ route('admin.movimientos.index') }}"
                            class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                            {{ request()->routeIs('admin.movimientos.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                            🔄 Movimientos (VoBo)
                          </a>
                        </li>
                        <li>
                          <a href="{{ route('secretaria.vobo') }}"
                             class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                             {{ request()->routeIs('secretaria.vobo') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                            📝 VoBo
                          </a>
                        </li>
                      @endunlessrole
                    @endcan

                    {{-- ===== Usuario general: SOLO Mi Inventario ===== --}}
                    @role('Usuario')
                      @unless($u->can('aprobar movimientos') || $u->can('vobo movimientos') || $u->hasRole('Admin'))
                        <li>
                          <a href="{{ route('usuarios.dashboard') }}"
                             class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                             {{ request()->routeIs('usuarios.dashboard') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                            📁 Mi Inventario
                          </a>
                        </li>
                      @endunless
                    @endrole
                  </ul>
                </nav>

                {{-- ¡CAMBIO AQUÍ! 3. Hacemos que el área de contenido principal tenga su propio scroll --}}
                <div class="flex-1 flex flex-col overflow-y-auto">
                    
                    {{-- ¡CAMBIO AQUÍ! 4. Hacemos que el header se quede "pegado" arriba al hacer scroll --}}
                    <header class="bg-white dark:bg-gray-800 shadow sticky top-0 z-10">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header ?? '' }}
                        </div>
                    </header>
                    
                    <main class="flex-1">
                        <div class="py-6">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                {{ $slot }}
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>

        @stack('modals')
        @livewireScripts
        @livewireNavigateScripts
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="fixed top-4 right-4 z-50 px-4 py-2 bg-green-600 text-white rounded-lg shadow-lg">
                {{ session('success') }}
            </div>
        @endif
    </body>
</html>