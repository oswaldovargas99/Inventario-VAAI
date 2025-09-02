@php $dependencia = $dependencia ?? null; @endphp

@if ($errors->any())
  <div class="mb-3 p-3 rounded bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100">
    {{ $errors->first() }}
  </div>
@endif

<form action="{{ $route }}" method="POST" class="grid gap-4"> {{-- Eliminamos max-w-3xl, ya lo tiene el padre --}}
  @csrf
  @if($method === 'PUT') @method('PUT') @endif

  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm dark:text-gray-200">Nombre</label>
      <input name="nombre" value="{{ old('nombre', $dependencia->nombre ?? '') }}" required
             class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
    </div>
    <div>
      <label class="block text-sm dark:text-gray-200">Siglas</label>
      <input name="siglas" value="{{ old('siglas', $dependencia->siglas ?? '') }}" required
             class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
    </div>
  </div>

  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm dark:text-gray-200">Teléfono</label>
      <input name="telefono" value="{{ old('telefono', $dependencia->telefono ?? '') }}"
             class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
    </div>
    <div>
      <label class="block text-sm dark:text-gray-200">Dirección</label>
      <input name="direccion" value="{{ old('direccion', $dependencia->direccion ?? '') }}"
             class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
    </div>
  </div>

  <div class="flex gap-2 justify-end mt-4"> {{-- Ajuste de orden y estilos --}}
    <a href="{{ route('admin.dependencias.index') }}"
       class="px-4 py-2 rounded bg-gray-200 text-gray-800 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600">Cancelar</a>
    <button class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Guardar</button>
  </div>
</form>