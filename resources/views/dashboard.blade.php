{{-- resources/views/dashboard.blade.php --}}
<x-app-layout> {{-- CAMBIO A x-app-layout --}}
    <x-slot name="header"> {{-- Define el slot para la barra superior --}}
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-ui.section-title
      title="Dashboard"
      subtitle="Resumen general del inventario y accesos rápidos"
    />

    {{-- KPIs --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      <x-ui.kpi-card label="Equipos totales" value="{{ $totalEquipos ?? 0 }}" />
      <x-ui.kpi-card label="Asignados" value="{{ $equiposAsignados ?? 0 }}" />
      <x-ui.kpi-card label="En almacén" value="{{ $equiposEnAlmacen ?? 0 }}" />
      <x-ui.kpi-card label="En mantenimiento" value="{{ $equiposEnMantenimiento ?? 0 }}" />
    </div>

    {{-- Accesos rápidos --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
      @can('ver inventario')
        <a href="{{ route('admin.equipos.index') }}"
           class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 hover:shadow">
          <div class="text-sm text-gray-600 dark:text-gray-400">Inventario</div>
          <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">Ver listado</div>
        </a>
      @endcan

      @role('Admin')
        <a href="{{ route('admin.users.index') }}"
           class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 hover:shadow">
          <div class="text-sm text-gray-600 dark:text-gray-400">Administración</div>
          <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">Gestión de usuarios</div>
        </a>
      @endrole

      @can('aprobar movimientos')
        <a href="{{ route('patrimonio.aprobaciones') }}"
           class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 hover:shadow">
          <div class="text-sm text-gray-600 dark:text-gray-400">Patrimonio</div>
          <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">Aprobaciones</div>
        </a>
      @endcan
    </div>

    {{-- Últimos movimientos (placeholder) --}}
    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
      <div class="p-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100">Últimos movimientos</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Se habilitará con inventarios_movimientos.</p>
      </div>
      <div class="p-4">
        <div class="text-sm text-gray-600 dark:text-gray-400">Sin datos por ahora.</div>
      </div>
    </div>
</x-app-layout>