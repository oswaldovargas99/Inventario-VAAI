{{-- resources/views/usuarios/mi_inventario.blade.php --}}
<x-layouts.inventario>
    <x-slot:headerTitle>Mi Inventario</x-slot:headerTitle>

    <x-slot:breadcrumbs>
        <x-ui.breadcrumbs :items="[['label'=>'Mi Inventario']]" />
    </x-slot:breadcrumbs>

    <x-ui.section-title
        title="Mi Inventario"
        subtitle="Equipos actualmente asignados a tu usuario"
    />

    <div class="overflow-x-auto rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Equipo</th>
                    <th class="px-4 py-2">Categoría</th>
                    <th class="px-4 py-2">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-700 dark:text-gray-200">
                <tr>
                    <td class="px-4 py-2">1</td>
                    <td class="px-4 py-2">Laptop Dell</td>
                    <td class="px-4 py-2">Cómputo</td>
                    <td class="px-4 py-2">Asignado</td>
                </tr>
                <tr>
                    <td class="px-4 py-2">2</td>
                    <td class="px-4 py-2">Monitor LG 24”</td>
                    <td class="px-4 py-2">Periférico</td>
                    <td class="px-4 py-2">Asignado</td>
                </tr>
            </tbody>
        </table>
    </div>

    <p class="text-sm text-gray-500 dark:text-gray-400 mt-3">
        *Ejemplo para Usuario. En fases posteriores se filtrará automáticamente por <code>user_id</code>.
    </p>
</x-layouts.inventario>
