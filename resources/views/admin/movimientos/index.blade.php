{{-- resources/views/inventario/general.blade.php --}}
<x-app-layout> {{-- Ahora extiende x-app-layout directamente --}}
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Movimientos') }} {{-- Puedes usar el headerTitle aquí si lo necesitas --}}
    </h2>
  </x-slot>

  <x-ui.section-title
    title="Movimientos de equipo"
    subtitle="Listado global de moivimientos de equipos registrados en el sistema"
  />

  <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-4">

      {{-- Formulario de Filtros y Botones --}}
      <form method="GET" class="mb-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
          {{-- Tipo de movimiento --}}
          <div>
            <label for="tipo_movimiento" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tipo</label>
            <select name="tipo_movimiento" id="tipo_movimiento" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
              <option value="">— Tipo —</option>
              @foreach($tipos as $t)
                <option value="{{ $t }}" @selected(request('tipo_movimiento')===$t)>{{ $t }}</option>
              @endforeach
            </select>
          </div>

          {{-- Estado de aprobación --}}
          <div>
            <label for="estado_aprobacion" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Estado</label>
            <select name="estado_aprobacion" id="estado_aprobacion" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
              <option value="">— Estado —</option>
              @foreach($estados as $e)
                <option value="{{ $e }}" @selected(request('estado_aprobacion')===$e)>{{ $e }}</option>
              @endforeach
            </select>
          </div>

          {{-- Dependencia --}}
          <div>
            <label for="dependencia_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Dependencia</label>
            <select name="dependencia_id" id="dependencia_id" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
              <option value="">— Dependencia —</option>
              @foreach($dependencias as $dep)
                <option value="{{ $dep->id }}" @selected(request('dependencia_id')==$dep->id)>{{ $dep->nombre }}</option>
              @endforeach
            </select>
          </div>

          {{-- Rango de Fechas --}}
          <div class="grid grid-cols-2 gap-4"> {{-- Sub-grid para las dos fechas --}}
            <div>
              <label for="desde" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Desde</label>
              <input type="date" name="desde" id="desde" value="{{ request('desde') }}"
                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            </div>
            <div>
              <label for="hasta" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Hasta</label>
              <input type="date" name="hasta" id="hasta" value="{{ request('hasta') }}"
                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            </div>
          </div>
        </div>

        {{-- Contenedor para el botón "Nuevo" y los botones de acción --}}
        <div class="mt-4 flex flex-col sm:flex-row gap-2 justify-between">
          {{-- Botón Nuevo --}}
          @can('movimientos.create')
            <a href="{{ route('admin.movimientos.create') }}"
               class="inline-flex items-center px-5 py-2 text-sm font-medium rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
              + Nuevo Movimiento
            </a>
          @endcan

          {{-- Botones de Filtrar y Limpiar --}}
          <div class="flex gap-2">
            <button type="submit"
              class="inline-flex items-center justify-center px-5 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-800 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
              <span class="flex items-center gap-2">🔍 Filtrar</span>
            </button>
            <a href="{{ route('admin.movimientos.index') }}"
              class="inline-flex items-center justify-center px-5 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-800 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
              <span class="flex items-center gap-2">❌ Limpiar</span>
            </a>
          </div>
        </div>
      </form>

      {{-- Tabla de Movimientos --}}
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
          <thead>
            <tr class="text-left bg-gray-50 dark:bg-gray-700">
              <th class="p-2 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">#</th>
              <th class="p-2 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Equipo</th>
              <th class="p-2 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Tipo</th>
              <th class="p-2 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Fecha</th>
              <th class="p-2 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Estado</th>
              <th class="p-2 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Resp.</th>
              <th class="p-2 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($movimientos as $m)
              <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/40">
                <td class="p-2 text-gray-900 dark:text-gray-100">{{ $m->id }}</td>
                <td class="p-2 text-gray-700 dark:text-gray-300">
                  @if($m->equipo)
                    {{ $m->equipo->numero_serie ?? 'Equipo #'.$m->equipo_id }}
                  @else
                    #{{ $m->equipo_id }}
                  @endif
                </td>
                <td class="p-2 text-gray-700 dark:text-gray-300">{{ $m->tipo_movimiento->value }}</td>
                <td class="p-2 text-gray-700 dark:text-gray-300">{{ $m->fecha_movimiento?->format('d/m/Y') }}</td>
                <td class="p-2">
                  <span class="px-2 py-1 rounded-full text-xs
                    @class([
                      'bg-yellow-100 text-yellow-800' => $m->estado_aprobacion->value === 'Pendiente',
                      'bg-blue-100 text-blue-800' => $m->estado_aprobacion->value === 'Aprobado_Patrimonio',
                      'bg-green-100 text-green-800' => $m->estado_aprobacion->value === 'Aprobado_Secretaria',
                      'bg-red-100 text-red-800' => $m->estado_aprobacion->value === 'Rechazado',
                    ])">
                    {{ $m->estado_aprobacion->value }}
                  </span>
                </td>
                <td class="p-2 text-gray-700 dark:text-gray-300">{{ $m->responsable?->name }}</td>
                <td class="p-2 flex flex-wrap gap-2 justify-end"> {{-- Alineamos acciones a la derecha --}}
                  @can('movimientos.edit')
                    @if($m->estado_aprobacion->value === 'Pendiente')
                      <a href="{{ route('admin.movimientos.edit',$m) }}"
                        class="px-3 py-1 text-xs rounded-md border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">Editar</a>
                    @endif
                  @endcan

                  @can('movimientos.approve')
                    @if($m->estado_aprobacion->value === 'Pendiente')
                      <form method="POST" action="{{ route('admin.movimientos.aprobarPatrimonio',$m) }}">
                        @csrf
                        <button class="px-3 py-1 text-xs rounded-md border border-green-300 text-green-700 hover:bg-green-50">Aprobar Patrimonio</button>
                      </form>
                    @elseif($m->estado_aprobacion->value === 'Aprobado_Patrimonio')
                      <form method="POST" action="{{ route('admin.movimientos.aprobarSecretaria',$m) }}">
                        @csrf
                        <button class="px-3 py-1 text-xs rounded-md border border-emerald-300 text-emerald-700 hover:bg-emerald-50">VoBo Secretaría</button>
                      </form>
                    @endif

                    @if(in_array($m->estado_aprobacion->value, ['Pendiente','Aprobado_Patrimonio']))
                      <form method="POST" action="{{ route('admin.movimientos.rechazar',$m) }}">
                        @csrf
                        {{-- Puedes hacer que el comentario sea un input modal si es necesario, por ahora es fijo --}}
                        <input type="hidden" name="comentarios_aprobacion" value="Rechazado por revisión inicial.">
                        <button class="px-3 py-1 text-xs rounded-md border border-red-300 text-red-700 hover:bg-red-50">Rechazar</button>
                      </form>
                    @endif
                  @endcan

                  @can('movimientos.delete')
                    @if($m->estado_aprobacion->value === 'Pendiente')
                      <form method="POST" action="{{ route('admin.movimientos.destroy',$m) }}" onsubmit="return confirm('¿Eliminar este movimiento? Solo si está Pendiente.');">
                        @csrf @method('DELETE')
                        <button class="px-3 py-1 text-xs rounded-md border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">Eliminar</button>
                      </form>
                    @endif
                  @endcan
                </td>
              </tr>
            @empty
              <tr><td colspan="7" class="p-4 text-center text-gray-500 dark:text-gray-400">Sin movimientos registrados con los criterios seleccionados.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-4">{{ $movimientos->onEachSide(1)->links() }}</div>
    </div>
  </div>
</x-app-layout>