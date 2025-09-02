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
            {{-- Puedes tener una barra de navegación superior aquí si es necesario --}}
            {{-- @include('layouts.navigation-top') --}}

            <div class="flex"> {{-- Contenedor principal: Barra lateral + Contenido principal --}}
                <nav class="flex-none w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 p-4">
                  <ul class="space-y-1 px-2">
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
                      
                      {{-- ===== Dependencias (Añadido) ===== --}}
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
                {{-- ========================================================================================== --}}

                <div class="flex-1 flex flex-col"> {{-- Contenedor para la barra superior y el contenido principal --}}
                    {{-- === BARRA SUPERIOR (TU HEADER) === --}}
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                            {{-- Contenido inyectado directamente por x-slot name="header" --}}
                            {{-- Este slot ahora es el que debe tener el h2 y el botón, ya que este div tiene flex --}}
                            {{ $header ?? '' }}

                            {{-- Información del usuario y botón de salir --}}
                            <div class="flex items-center space-x-4">
                                <span class="text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</span>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-sm text-red-600 hover:underline">Salir</button>
                                </form>
                                {{-- Si tienes un toggle de tema oscuro, iría aquí --}}
                            </div>
                        </div>
                    </header>
                    {{-- =================================== --}}

                    <main class="flex-1">
                        <div class="py-6">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                {{ $slot }}
                            </div>
                        </div>
                    </main>
                    {{-- ===================================== --}}

                </div> {{-- Fin del div flex-1 flex flex-col --}}

            </div> {{-- Fin del div flex (principal) --}}
        </div> {{-- Fin del min-h-screen --}}

        @stack('modals')
        @livewireScripts
        @livewireNavigateScripts
        {{-- Mensaje flash global, como ya lo movimos aquí --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="fixed top-4 right-4 z-50 px-4 py-2 bg-green-600 text-white rounded-lg shadow-lg">
                {{ session('success') }}
            </div>
        @endif
    </body>
</html>