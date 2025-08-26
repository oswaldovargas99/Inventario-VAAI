{{-- resources/views/admin/equipos/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Inventario — Equipos') }}
            </h2>
            @can('create', App\Models\Inventarios\Equipo::class)
                <a href="{{ route('admin.equipos.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    + Nuevo Equipo
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-4">
            <!-- Filtros -->
            <form method="GET" class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex flex-col md:flex-row gap-3">
                <x-input id="q" name="q" value="{{ $q }}" placeholder="Buscar (serie, marca, modelo, activo, MAC)" class="w-full md:w-1/3"/>
                <select name="dependencia_id" class="w-full md:w-1/4 rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                    <option value="">— Dependencia —</option>
                    @foreach($dependencias as $d)
                        <option value="{{ $d->id }}" @selected($dep==$d->id)>{{ $d->nombre }}</option>
                    @endforeach
                </select>
                <select name="tipo_equipo_id" class="w-full md:w-1/4 rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                    <option value="">— Tipo —</option>
                    @foreach($tipos as $t)
                        <option value="{{ $t->id }}" @selected($tip==$t->id)>{{ $t->nombre }}</option>
                    @endforeach
                </select>
                <select name="estado" class="w-full md:w-1/4 rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                    <option value="">— Estado —</option>
                    @foreach($estados as $e)
                        <option value="{{ $e }}" @selected($est==$e)>{{ $e }}</option>
                    @endforeach
                </select>
                <button class="px-4 py-2 bg-gray-200 dark:bg-gray-600 rounded-md">Filtrar</button>
            </form>

            <!-- Tabla -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold">Serie</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">Tipo</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">Marca/Modelo</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">Dep.</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">Estado</th>
                                <th class="px-4 py-2 text-right text-xs font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($equipos as $eq)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                    <td class="px-4 py-2 font-mono">{{ $eq->numero_serie }}</td>
                                    <td class="px-4 py-2">{{ $eq->tipo?->nombre }}</td>
                                    <td class="px-4 py-2">{{ $eq->marca }} {{ $eq->modelo }}</td>
                                    <td class="px-4 py-2">{{ $eq->dependencia?->nombre }}</td>
                                    <td class="px-4 py-2">
                                        <span class="inline-flex items-center text-xs px-2 py-1 rounded-full
                                            @class([
                                                'bg-gray-200 text-gray-800' => $eq->estado==='En Almacén',
                                                'bg-green-200 text-green-800' => $eq->estado==='Asignado',
                                                'bg-yellow-200 text-yellow-800' => $eq->estado==='En Préstamo',
                                                'bg-orange-200 text-orange-800' => $eq->estado==='En Mantenimiento',
                                                'bg-red-200 text-red-800' => $eq->estado==='Baja',
                                            ])">
                                            {{ $eq->estado }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        <div class="inline-flex gap-2">
                                            <a href="{{ route('admin.equipos.edit',$eq) }}" class="text-indigo-600 hover:underline">Editar</a>
                                            <form method="POST" action="{{ route('admin.equipos.destroy',$eq) }}"
                                                  onsubmit="return confirm('¿Eliminar equipo?');">
                                                @csrf @method('DELETE')
                                                <button class="text-red-600 hover:underline">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="p-6 text-center text-gray-500 dark:text-gray-400">Sin resultados</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-3">
                    {{ $equipos->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
