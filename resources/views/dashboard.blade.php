{{-- Dashboard: usa layout inventario y pasa breadcrumbs --}}
<x-layouts.inventario>
    <x-slot:breadcrumbs>
        <x-ui.breadcrumbs :items="[['label'=>'Dashboard']]" />
    </x-slot:breadcrumbs>

    <x-ui.section-title title="Dashboard"
        subtitle="Resumen general del inventario y accesos rápidos" />

    {{-- KPIs placeholder: se conectarán en Fase 4/5 --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-ui.kpi-card label="Equipos totales" value="0" hint="Se actualizará en Fase 4" />
        <x-ui.kpi-card label="Asignados" value="0" hint="Fase 5 (movimientos efectivos)" />
        <x-ui.kpi-card label="En almacén" value="0" hint="Por estado del equipo" />
        <x-ui.kpi-card label="En mantenimiento" value="0" hint="Por estado del equipo" />
    </div>

    {{-- Accesos rápidos por permiso/rol --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        @can('ver inventario')
            <a href="#"
               class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 hover:shadow">
                <div class="text-sm text-gray-600 dark:text-gray-400">Inventario</div>
                <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">Ver listado</div>
            </a>
        @endcan

        @role('Admin')
            <a href="{{ route('admin.home') }}"
               class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 hover:shadow">
                <div class="text-sm text-gray-600 dark:text-gray-400">Administración</div>
                <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">Panel Admin</div>
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

    {{-- Últimos movimientos (placeholder, se llenará en Fase 5) --}}
    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100">Últimos movimientos</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Se habilitará cuando exista inventarios_movimientos</p>
        </div>
        <div class="p-4">
            <div class="text-sm text-gray-600 dark:text-gray-400">Sin datos por ahora.</div>
        </div>
    </div>
</x-layouts.inventario>
