{{-- resources/views/inventario/general.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Movimientos') }}
    </h2>
  </x-slot>

  <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-4">
      {{-- Formulario de Filtros y Botones --}}
      <form method="GET" class="mb-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-4">
          {{-- === ¡NUEVO CAMPO DE FILTRO POR EQUIPO! === --}}
          <div class="lg:col-span-2">
            <label for="equipo_q" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Buscar Equipo</label>
            <input type="text" name="equipo_q" id="equipo_q" value="{{ $equipo_q ?? '' }}"
              placeholder="Serie, activo, marca, modelo"
              class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
          </div>
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

          {{-- === NUEVO FILTRO: Resguardante === --}}
          <div>
            <label for="resguardante_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Resguardante</label>
            <select name="resguardante_id" id="resguardante_id" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
              <option value="">— Todos —</option>
              @foreach($usuarios as $user) {{-- $usuarios debe ser pasado desde el controlador --}}
                <option value="{{ $user->id }}" @selected(request('resguardante_id')==$user->id)>{{ $user->name }}</option>
              @endforeach
            </select>
          </div>
          {{-- Fin NUEVO FILTRO --}}

          {{-- Rango de Fechas (ajustado para la nueva columna del filtro de resguardante) --}}
          <div class="grid grid-cols-2 gap-4 lg:col-span-2"> {{-- Ajusta el col-span si es necesario --}}
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
              class="inline-flex items-center justify-center px-5 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-800 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600 dark:focus:ring-offset-800 transition ease-in-out duration-150">
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
              <th class="p-2 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Resguardante</th>
              <th class="p-2 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Fecha Retorno</th>
              <th class="p-2 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($movimientos as $m)
              <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/40">
                <td class="p-2 text-gray-900 dark:text-gray-100">{{ $m->id }}</td>
                <td class="p-2 text-gray-700 dark:text-gray-300">
                  @if($m->equipo)
                    {{ $m->equipo->tipo?->nombre }} — {{ $m->equipo->id_activo_fijo ?? $m->equipo->numero_serie }}
                  @else
                    #{{ $m->equipo_id }}
                  @endif
                </td>
                <td class="p-2 text-gray-700 dark:text-gray-300">{{ $m->tipo_movimiento->value }}</td>
                <td class="p-2 text-gray-700 dark:text-gray-300">{{ $m->fecha_movimiento?->format('d/m/Y') }}</td>
                <td class="p-2 text-gray-700 dark:text-gray-300">
                  {{ $m->usuarioAsignado?->name ?? 'N/A' }}
                </td>
                <td class="p-2 text-gray-700 dark:text-gray-300">
                  @if($m->fecha_retorno_esperada)
                    {{ $m->fecha_retorno_esperada->format('d/m/Y') }}
                  @else
                    N/A
                  @endif
                </td>
                <td class="p-2 flex flex-wrap gap-2 justify-end">
                  <a href="{{ route('admin.movimientos.show', $m) }}"
                    class="px-3 py-1 text-xs rounded-md border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">Ver</a>
                  @can('movimientos.edit')
                    @if($m->estado_aprobacion->value === 'Pendiente')
                      <a href="{{ route('admin.movimientos.edit',$m) }}"
                        class="px-3 py-1 text-xs rounded-md border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">Editar</a>
                    @endif
                  @endcan

                  @can('movimientos.approve')
                    @if($m->estado_aprobacion->value === 'Pendiente')
                        <button type="button" onclick="openAprobacionModal('{{ route('admin.movimientos.aprobarPatrimonio', $m) }}', '{{ route('admin.movimientos.rechazar', $m) }}')"
                            class="px-3 py-1 text-xs rounded-md border border-blue-300 text-blue-700 hover:bg-blue-50">Revisar Patrimonio</button>
                    @elseif($m->estado_aprobacion->value === 'Aprobado_Patrimonio')
                        <button type="button" onclick="openAprobacionModal('{{ route('admin.movimientos.aprobarSecretaria', $m) }}', '{{ route('admin.movimientos.rechazar', $m) }}')"
                            class="px-3 py-1 text-xs rounded-md border border-green-300 text-green-700 hover:bg-green-50">VoBo Secretaría</button>
                    @endif

                    @if(in_array($m->estado_aprobacion->value, ['Pendiente','Aprobado_Patrimonio']))
                      {{-- El botón "Rechazar" aquí también abre el modal para comentarios --}}
                      <button type="button" onclick="openAprobacionModal('{{ route('admin.movimientos.aprobarSecretaria', $m) }}', '{{ route('admin.movimientos.rechazar', $m) }}')"
                          class="px-3 py-1 text-xs rounded-md border border-red-300 text-red-700 hover:bg-red-50">Rechazar</button>
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

  {{-- Modal para Aprobación/Rechazo --}}
  <div id="aprobacionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
      <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mb-4">Revisar Movimiento</h3>
      <form id="aprobacionForm" method="POST">
        @csrf
        <div>
          <label for="modal_comentarios_aprobacion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Comentarios (requerido para rechazo)</label>
          <textarea name="comentarios_aprobacion" id="modal_comentarios_aprobacion" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-100"></textarea>
        </div>
        <div class="mt-4 flex justify-end space-x-2">
          <button type="submit" id="aprobarModalBtn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Aprobar</button>
          <button type="submit" id="rechazarModalBtn" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Rechazar</button>
          <button type="button" onclick="document.getElementById('aprobacionModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md dark:bg-gray-700 dark:text-gray-100">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function openAprobacionModal(approveUrl, rejectUrl) {
      const modal = document.getElementById('aprobacionModal');
      const form = document.getElementById('aprobacionForm');
      const aprobarBtn = document.getElementById('aprobarModalBtn');
      const rechazarBtn = document.getElementById('rechazarModalBtn');
      const comentarios = document.getElementById('modal_comentarios_aprobacion');

      comentarios.value = ''; // Limpiar comentarios previos

      // Importante: Clonar los botones para remover los listeners existentes
      const newAprobarBtn = aprobarBtn.cloneNode(true);
      const newRechazarBtn = rechazarBtn.cloneNode(true);
      aprobarBtn.parentNode.replaceChild(newAprobarBtn, aprobarBtn);
      rechazarBtn.parentNode.replaceChild(newRechazarBtn, rechazarBtn);

      newAprobarBtn.onclick = function() {
        form.action = approveUrl;
        form.method = 'POST';
        form.submit();
      };

      newRechazarBtn.onclick = function() {
        if (comentarios.value.length < 5) {
          alert('Los comentarios son requeridos y deben tener al menos 5 caracteres para rechazar el movimiento.');
          return false; // Evita que el formulario se envíe
        }
        form.action = rejectUrl;
        form.method = 'POST';
        form.submit();
      };

      modal.classList.remove('hidden');
    }
  </script>

</x-app-layout>