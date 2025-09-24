{{-- resources/views/equipos/_list_content.blade.php --}}

<div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6">
  <form method="GET" action="{{ route(request()->routeIs('admin.equipos.index') ? 'admin.equipos.index' : 'inventario.general') }}">

    {{-- Primera fila de filtros: Dependencia (2/3) y Búsqueda (1/3) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
      {{-- Dependencia --}}
      <div class="md:col-span-2"> {{-- Ocupa 2 de 3 columnas en pantallas medianas y grandes --}}
        <label for="dependencia_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Dependencia</label>
        <select name="dependencia_id" id="dependencia_id"
          class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
          <option value="">Dependencia</option>
          @foreach($dependencias as $d)
            <option value="{{ $d->id }}" @selected($dep==$d->id)>{{ $d->nombre }}</option>
          @endforeach
        </select>
      </div>
      {{-- Búsqueda --}}
      <div> {{-- Ocupa 1 de 3 columnas en pantallas medianas y grandes --}}
        <label for="q" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Buscar</label>
        <x-input id="q" name="q" value="{{ $q }}"
          placeholder="Buscar (serie, marca, modelo, activo, MAC)" class="w-full" />
      </div>
    </div>

    {{-- Segunda fila de filtros: Tipo, Estado, Filtrar, Limpiar (todos al mismo nivel) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      {{-- Tipo --}}
      <div>
        <label for="tipo_equipo_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tipo</label>
        <select name="tipo_equipo_id" id="tipo_equipo_id"
          class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
          <option value="">Tipo</option>
          @foreach($tipos as $t)
            <option value="{{ $t->id }}" @selected($tip==$t->id)>{{ $t->nombre }}</option>
          @endforeach
        </select>
      </div>
      {{-- Estado --}}
      <div>
        <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Estado</label>
        <select name="estado" id="estado"
          class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
          <option value="">Estado</option>
          @foreach($estados as $e)
            <option value="{{ $e }}" @selected($est==$e)>{{ $e }}</option>
          @endforeach
        </select>
      </div>

      {{-- Botones de Filtrar y Limpiar (integrados y alineados) --}}
      <div class="flex items-end"> {{-- Usamos flex items-end para alinear los botones a la parte inferior de la celda --}}
        <button type="submit"
          class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
          <span class="flex items-center gap-2">🔍 Filtrar</span>
        </button>
      </div>
      <div class="flex items-end"> {{-- Usamos flex items-end para alinear los botones a la parte inferior de la celda --}}
        <a href="{{ route(request()->routeIs('admin.equipos.index') ? 'admin.equipos.index' : 'inventario.general') }}"
          class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-800 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
          <span class="flex items-center gap-2">❌ Limpiar</span>
        </a>
      </div>
    </div>
  </form>
</div>

{{-- Tabla --}}
<div class="overflow-x-auto rounded-lg shadow">
  <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
    <thead class="bg-gray-50 dark:bg-gray-800">
      <tr>
        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Serie</th>
        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Equipo</th>
        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Dependencia</th>
       <!-- <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Ubicación</th> -->
        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Estado</th>
        <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Adquisición</th>
        @canany(['equipos.update','equipos.delete'])
          <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Acciones</th>
        @endcanany
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
                'bg-gray-200 text-gray-800'     => $equipo->estado === 'En Almacén',
                'bg-green-200 text-green-800'   => $equipo->estado === 'Asignado',
                'bg-yellow-200 text-yellow-800' => $equipo->estado === 'En Préstamo',
                'bg-orange-200 text-orange-800' => $equipo->estado === 'En Mantenimiento',
                'bg-red-200 text-red-800'       => $equipo->estado === 'Baja',
              ])">
              {{ $equipo->estado }}
            </span>
          </td>
          <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
            {{ optional($equipo->fecha_adquisicion)->format('d/m/Y') ?? '-' }}
          </td>

          @canany(['equipos.update','equipos.delete'])
            <td class="px-4 py-2 text-right text-sm">
              <div class="inline-flex gap-2">
                @can('equipos.update')
                  <a href="{{ route('admin.equipos.edit', ['equipo' => $equipo->id]) }}"
                    class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                    Editar
                  </a>
                @endcan

                @can('equipos.delete')
                  <form x-data
                        x-on:submit.prevent="if(confirm('¿Eliminar este equipo? Esta acción se puede revertir (soft delete).')) $el.submit()"
                        method="POST"
                        action="{{ route('admin.equipos.destroy', $equipo) }}">
                    @csrf
                    @method('DELETE')
                    <button class="px-3 py-1 rounded-md border border-red-300 text-red-700 hover:bg-red-50">
                      Eliminar
                    </button>
                  </form>
                @endcan
              </div>
            </td>
          @endcanany
        </tr>
      @empty
        <tr>
          <td colspan="@canany(['equipos.update','equipos.delete']) 7 @else 6 @endcanany"
              class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
            No se encontraron equipos con los criterios seleccionados.
            @can('equipos.create')
              <div class="mt-3">
                <a href="{{ route('admin.equipos.create') }}"
                  class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                  + Registrar un equipo
                </a>
              </div>
            @endcan
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