<x-app-layout>
    <x-slot:headerTitle>Mi Inventario</x-slot:headerTitle>

    <x-ui.section-title
        title="Mi Inventario"
        subtitle="Equipos actualmente asignados a tu usuario"
    />

    <div class="overflow-x-auto rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Equipo</th>
                    <th class="px-4 py-3">ID Activo Fijo / Serie</th>
                    <th class="px-4 py-3">Categoría</th>
                    <th class="px-4 py-3">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-700 dark:text-gray-200">
                @forelse ($equipos as $equipo)
                    <tr>
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium">
                            {{ $equipo->descripcion ?? ($equipo->marca . ' ' . $equipo->modelo) }}
                        </td>
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                            {{ $equipo->id_activo_fijo ?? $equipo->numero_serie }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $equipo->tipo?->nombre ?? 'Sin categoría' }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                {{ $equipo->estado ?? 'Asignado' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                            No tienes equipos asignados actualmente.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>