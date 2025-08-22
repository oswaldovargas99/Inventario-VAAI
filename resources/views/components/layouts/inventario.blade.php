{{-- resources/views/components/layouts/inventario.blade.php --}}
@props(['headerTitle' => null])

<x-layouts.app>
  <div class="flex min-h-screen">
    {{-- Sidebar --}}
    <aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 hidden md:flex flex-col">
      <div class="p-4 font-bold text-lg text-gray-900 dark:text-gray-100">
        {{ config('app.name', 'Inventario UDG') }}
      </div>
      <nav class="flex-1">
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
            
            <li>
              <a href="{{ route('admin.dependencias.index') }}"
                class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                {{ request()->routeIs('admin.dependencias.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                🏢 Dependencias
              </a>
            </li>

            <li>
              <a href="{{ route('inventario.general') }}"
                class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                {{ request()->routeIs('inventario.general') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                📦 Inventario
              </a>
            </li>

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

          {{-- ===== Aprobador (NO Admin) ===== --}}
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
                <a href="{{ route('inventario.general') }}"
                  class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                  {{ request()->routeIs('inventario.general') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                  📦 Inventario
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

          {{-- ===== VoBo (NO Admin) ===== --}}
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
                <a href="{{ route('inventario.general') }}"
                  class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
                  {{ request()->routeIs('inventario.general') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                  📦 Inventario
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

    </aside>

    {{-- Contenido --}}
    <div class="flex-1 flex flex-col">
      {{-- Topbar --}}
      <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-4 py-2 flex justify-between items-center">
        <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
          {{ $headerTitle ?? 'Panel' }}
        </div>
        <div class="flex items-center gap-3">
          <button @click="dark = !dark" class="px-2 py-1 rounded border dark:border-gray-700">
            <span x-show="!dark">🌙</span>
            <span x-show="dark" x-cloak>☀️</span>
          </button>
          <span class="text-gray-600 dark:text-gray-300">{{ Auth::user()->name }}</span>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-sm text-red-600 hover:underline">Salir</button>
          </form>
        </div>
      </header>

      <main class="flex-1 p-6">
        {{ $slot }}
      </main>
    </div>
  </div>
</x-layouts.app>
