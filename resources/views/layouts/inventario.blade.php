{{-- resources/views/components/layouts/inventario.blade.php (solo el <nav>) --}}
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

      {{-- ===== Equipos ===== --}}
      @canany(['equipos.view','equipos.create','equipos.update','equipos.delete'])
        <li>
          <a href="{{ route('admin.equipos.index') }}"
            class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
            {{ request()->routeIs('admin.equipos.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
            🖥️ Equipos (Admin) {{-- Renombrado para diferenciar --}}
          </a>
        </li>
      @endcanany


      <li>
        <a href="{{ route('inventario.general') }}"
           class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
           {{ request()->routeIs('inventario.general') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
          📦 Inventario General
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
          <a href="{{ route('inventario.general') }}"
             class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
             {{ request()->routeIs('inventario.general') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
            📦 Inventario General
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
          <a href="{{ route('inventario.general') }}"
             class="block px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700
             {{ request()->routeIs('inventario.general') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
            📦 Inventario General
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