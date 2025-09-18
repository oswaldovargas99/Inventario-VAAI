<x-app-layout>
  <x-slot name="headerTitle">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Editar Movimiento</h2>
  </x-slot>

{{-- Mensajes de error globales, si no los tienes en layouts/app.blade.php --}}
@if ($errors->any())
  <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-red-700">
    <strong>Corrige los siguientes campos:</strong>
    <ul class="list-disc pl-5">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

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
              {{-- === ¡MODIFICACIÓN AQUÍ! Mostramos tipo y número de serie y seleccionamos el actual === --}}
              <option value="{{ $e->id }}" @selected(old('equipo_id', $movimiento->equipo_id) == $e->id)>
                {{ $e->tipo?->nombre }} — {{ $e->numero_serie }}
              </option>
              {{-- ================================================================================= --}}
            @endforeach
          </select>
          @error('equipo_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm mb-1">Tipo de movimiento</label>
          <select name="tipo_movimiento" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100" required>
            <option value="">-- Selecciona --</option>
            @foreach($tipos as $t)
              <option value="{{ $t }}" @selected(old('tipo_movimiento', $movimiento->tipo_movimiento->value) == $t)>{{ $t }}</option>
            @endforeach
          </select>
          @error('tipo_movimiento') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm mb-1">Usuario asignado (si aplica)</label>
          <select name="usuario_asignado_id" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
            <option value="">-- N/A --</option>
            @foreach($usuarios as $u)
              <option value="{{ $u->id }}" @selected(old('usuario_asignado_id', $movimiento->usuario_asignado_id) == $u->id)>{{ $u->name }}</option>
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
                <option value="{{ $d->id }}" @selected(old('dependencia_origen_id', $movimiento->dependencia_origen_id) == $d->id)>{{ $d->nombre }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-sm mb-1">Dependencia destino</label>
            <select name="dependencia_destino_id" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
              <option value="">-- N/A --</option>
              @foreach($dependencias as $d)
                <option value="{{ $d->id }}" @selected(old('dependencia_destino_id', $movimiento->dependencia_destino_id) == $d->id)>{{ $d->nombre }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm mb-1">Fecha del movimiento</label>
            <input type="date" name="fecha_movimiento" value="{{ old('fecha_movimiento', $movimiento->fecha_movimiento?->format('Y-m-d')) }}" required class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
          </div>
          <div>
            <label class="block text-sm mb-1">Fecha retorno esperada (si aplica)</label>
            <input type="date" name="fecha_retorno_esperada" value="{{ old('fecha_retorno_esperada', $movimiento->fecha_retorno_esperada?->format('Y-m-d')) }}" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
          </div>
        </div>

        <div>
          <label class="block text-sm mb-1">Motivo / Comentarios</label>
          <textarea name="motivo" rows="3" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">{{ old('motivo', $movimiento->motivo) }}</textarea>
        </div>

        <div class="flex justify-end gap-2">
          <a href="{{ route('admin.movimientos.index') }}" class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700">Cancelar</a>
          <button class="px-4 py-2 rounded bg-indigo-600 text-white">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>