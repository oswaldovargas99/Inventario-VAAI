<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Nuevo Movimiento</h2>
  </x-slot>

  <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
      <form method="POST" action="{{ route('admin.movimientos.update', $movimiento) }}" class="grid gap-4">
        @method('PUT')
        @csrf

        <div>
          <label class="block text-sm mb-1">Equipo</label>
          <select name="equipo_id" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100" required>
            <option value="">-- Selecciona --</option>
            @foreach($equipos as $e)
              <option value="{{ $e->id }}">#{{ $e->id }} — {{ $e->numero_serie }} (Dep: {{ $e->dependencia_id }})</option>
            @endforeach
          </select>
          @error('equipo_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm mb-1">Tipo de movimiento</label>
          <select name="tipo_movimiento" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100" required>
            <option value="">-- Selecciona --</option>
            @foreach($tipos as $t)
              <option value="{{ $t }}">{{ $t }}</option>
            @endforeach
          </select>
          @error('tipo_movimiento') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm mb-1">Usuario asignado (si aplica)</label>
          <select name="usuario_asignado_id" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- N/A --</option>
            @foreach($usuarios as $u)
              <option value="{{ $u->id }}">{{ $u->name }}</option>
            @endforeach
          </select>
          @error('usuario_asignado_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm mb-1">Dependencia origen</label>
            <select name="dependencia_origen_id" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
              <option value="">-- N/A --</option>
              @foreach($dependencias as $d)
                <option value="{{ $d->id }}">{{ $d->nombre }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-sm mb-1">Dependencia destino</label>
            <select name="dependencia_destino_id" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
              <option value="">-- N/A --</option>
              @foreach($dependencias as $d)
                <option value="{{ $d->id }}">{{ $d->nombre }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm mb-1">Fecha del movimiento</label>
            <input type="date" name="fecha_movimiento" required class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
          </div>
          <div>
            <label class="block text-sm mb-1">Fecha retorno esperada (si aplica)</label>
            <input type="date" name="fecha_retorno_esperada" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
          </div>
        </div>

        <div>
          <label class="block text-sm mb-1">Motivo / Comentarios</label>
          <textarea name="motivo" rows="3" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100"></textarea>
        </div>

        <div class="flex justify-end gap-2">
          <a href="{{ route('admin.movimientos.index') }}" class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700">Cancelar</a>
          <button class="px-4 py-2 rounded bg-indigo-600 text-white">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>
