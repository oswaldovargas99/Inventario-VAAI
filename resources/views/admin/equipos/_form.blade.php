@csrf

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">

  {{-- Dependencia --}}
  <div>
    <label for="dependencia_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
      Dependencia <span class="text-red-500">*</span>
    </label>
    <select id="dependencia_id" name="dependencia_id" required
            class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
      <option value="">Selecciona...</option>
      @foreach($dependencias as $d)
        <option value="{{ $d->id }}" @selected(old('dependencia_id', $equipo->dependencia_id ?? '') == $d->id)>
          {{ $d->nombre }}
        </option>
      @endforeach
    </select>
    @error('dependencia_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  {{-- Tipo --}}
  <div>
    <label for="tipo_equipo_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
      Tipo <span class="text-red-500">*</span>
    </label>
    <select id="tipo_equipo_id" name="tipo_equipo_id" required
            class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
      <option value="">Selecciona...</option>
      @foreach($tipos as $t)
        <option value="{{ $t->id }}" @selected(old('tipo_equipo_id', $equipo->tipo_equipo_id ?? '') == $t->id)>{{ $t->nombre }}</option>
      @endforeach
    </select>
    @error('tipo_equipo_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  {{-- Estado --}}
  <div>
    <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
      Estado <span class="text-red-500">*</span>
    </label>
    <select id="estado" name="estado" required
            class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
      @foreach($estados as $e)
        <option value="{{ $e }}" @selected(old('estado', $equipo->estado ?? 'En Almacén') == $e)>{{ $e }}</option>
      @endforeach
    </select>
    @error('estado') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  {{-- Número de Serie --}}
  <div class="md:col-span-1">
    <label for="numero_serie" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
      Número de Serie <span class="text-red-500">*</span>
    </label>
    <input id="numero_serie" name="numero_serie" type="text" required
           value="{{ old('numero_serie', $equipo->numero_serie ?? '') }}"
           class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
    @error('numero_serie') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  {{-- Marca --}}
  <div class="md:col-span-1">
    <label for="marca" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
      Marca
    </label>
    <input id="marca" name="marca" type="text"
           value="{{ old('marca', $equipo->marca ?? '') }}"
           class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
    @error('marca') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  {{-- Modelo --}}
  <div class="md:col-span-1">
    <label for="modelo" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
      Modelo
    </label>
    <input id="modelo" name="modelo" type="text"
           value="{{ old('modelo', $equipo->modelo ?? '') }}"
           class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
    @error('modelo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  {{-- ID Activo Fijo --}}
  <div class="md:col-span-1">
    <label for="id_activo_fijo" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
      ID Activo Fijo
    </label>
    <input id="id_activo_fijo" name="id_activo_fijo" type="text"
           value="{{ old('id_activo_fijo', $equipo->id_activo_fijo ?? '') }}"
           class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
    @error('id_activo_fijo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  {{-- MAC --}}
  <div class="md:col-span-1">
    <label for="mac_address" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
      MAC (AA:BB:CC:DD:EE:FF)
    </label>
    <input id="mac_address" name="mac_address" type="text"
           value="{{ old('mac_address', $equipo->mac_address ?? '') }}"
           placeholder="AA:BB:CC:DD:EE:FF o AABBCCDDEEFF"
           class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
    @error('mac_address') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  {{-- Ubicación física --}}
  <div class="md:col-span-2">
    <label for="ubicacion_fisica" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
      Ubicación física
    </label>
    <input id="ubicacion_fisica" name="ubicacion_fisica" type="text"
           value="{{ old('ubicacion_fisica', $equipo->ubicacion_fisica ?? '') }}"
           class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
    @error('ubicacion_fisica') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  {{-- Fecha de adquisición --}}
  <div>
    <label for="fecha_adquisicion" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
      Fecha de adquisición
    </label>
    <input id="fecha_adquisicion" name="fecha_adquisicion" type="date"
           value="{{ old('fecha_adquisicion', optional($equipo->fecha_adquisicion ?? null)?->format('Y-m-d')) }}"
           class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
    @error('fecha_adquisicion') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  {{-- Descripción --}}
  <div class="md:col-span-3">
    <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
      Descripción
    </label>
    <textarea id="descripcion" name="descripcion" rows="3"
              class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">{{ old('descripcion', $equipo->descripcion ?? '') }}</textarea>
    @error('descripcion') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

</div>

  @php
    $cancelTo = request('return') === 'inventario.general'
        ? route('inventario.general')
        : route('admin.equipos.index');
  @endphp

  <div class="mt-6 flex justify-end gap-2">
    <a href="{{ $cancelTo }}"
      class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600">
      Cancelar
    </a>
    <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
      {{ $submitText ?? 'Guardar' }}
    </button>
</div>

