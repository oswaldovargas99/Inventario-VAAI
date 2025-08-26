{{-- resources/views/inventario/general.blade.php --}}
<x-layouts.inventario headerTitle="Inventario General">
  <x-ui.section-title 
    title="Inventario General" 
    subtitle="Listado global de equipos registrados en el sistema" 
  />

  {{-- Filtros --}}
  <form method="GET" action="{{ route('inventario.general') }}" class="mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      {{-- Búsqueda --}}
      <div>
        <input type="text" name="q" value="{{ request('q') }}" 
          placeholder="Buscar por serie, marca, modelo..." 
          class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" />
      </div>

      {{-- Dependencia --}}
      <div>
        <select name="dependencia_id"
          class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
          <option value="">Todas las dependencias</option>
          @foreach($dependencias as $d)
            <option value="{{ $d->id }}" @selected(request('dependencia_id') == $d->id)>
              {{ $d->nombre }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Tipo de equipo --}}
      <div>
        <select name="tipo_equipo_id"
          class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
          <option value="">Todos los tipos</option>
          @foreach($tipos as $t)
            <option value="{{ $t->id }}" @selected(request('tipo_equipo_id') == $t->id)>
              {{ $t->nombre }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Estado --}}
      <div>
        <select name="estado"
          class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
          <option value="">Todos los estados</option>
          @foreach($estados as $estado)
            <option value="{{ $estado }}" @selected(request('estado') == $estado)>
              {{ $estado }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="mt-4 flex gap-2">
      <button type="submit" 
        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
        🔍 Filtrar
      </button>
      <a href="{{ route('inventario.general') }}" 
        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">
        ❌ Limpiar
      </a>
    </div>
  </form>

  {{-- Tabla --}}
  <div class="overflow-x-auto rounded-lg shadow">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-gray-50 dark:bg-gray-800">
        <tr>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Serie</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Equipo</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Dependencia</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Ubicación</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Estado</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Adquisición</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900">
        @forelse($equipos as $equipo)
          <tr>
            <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $equipo->numero_serie }}</td>
            <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
              {{ $equipo->tipo?->nombre }} - {{ $equipo->marca }} {{ $equipo->modelo }}
            </td>
            <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $equipo->dependencia?->nombre }}</td>
            <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $equipo->ubicacion_fisica ?? '-' }}</td>
            <td class="px-4 py-2 text-sm">
              <span class="px-2 py-1 text-xs rounded-full
                @class([
                  'bg-green-100 text-green-800' => $equipo->estado === 'En Almacén',
                  'bg-blue-100 text-blue-800' => $equipo->estado === 'Asignado',
                  'bg-yellow-100 text-yellow-800' => $equipo->estado === 'En Préstamo',
                  'bg-orange-100 text-orange-800' => $equipo->estado === 'En Mantenimiento',
                  'bg-red-100 text-red-800' => $equipo->estado === 'Baja',
                ])">
                {{ $equipo->estado }}
              </span>
            </td>
            <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
              {{ optional($equipo->fecha_adquisicion)->format('d/m/Y') ?? '-' }}
            </td>
          </tr>
        @empty
          <tr>
          {{-- dentro de @empty en inventario/general.blade.php --}}
          <td colspan="6" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
            No se encontraron equipos con los criterios seleccionados.
            @canany(['equipos.create'])
              <div class="mt-3">
                {{-- inventario/general.blade.php, en el empty state o botón superior --}}
                <a href="{{ route('admin.equipos.create', ['return' => 'inventario.general']) }}"
                  class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                  + Registrar un equipo
                </a>
              </div>
            @endcanany
          </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Paginación --}}
  <div class="mt-4">
    {{ $equipos->onEachSide(1)->links() }}
  </div>
</x-layouts.inventario>
