{{-- resources/views/admin/equipos/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Inventario — Equipos (Administración)') }} {{-- Renombrado para diferenciar --}}
            </h2>
            @can('create', App\Models\Inventarios\Equipo::class)
                {{-- Eliminamos el parámetro 'return' --}}
                <a href="{{ route('admin.equipos.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    + Nuevo Equipo
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-4">
            {{-- Incluimos el nuevo partial de listado --}}
            @include('equipos._list_content', compact('equipos','dependencias','tipos','estados','q','dep','tip','est'))
        </div>
    </div>
</x-app-layout>