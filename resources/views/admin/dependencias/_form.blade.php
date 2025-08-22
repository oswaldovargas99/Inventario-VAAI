@php $dep = $dep ?? null; @endphp

@if ($errors->any())
  <div class="mb-3 p-3 rounded bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100">
    {{ $errors->first() }}
  </div>
@endif

<form action="{{ $route }}" method="POST" class="grid gap-4 max-w-3xl">
  @csrf
  @if($method === 'PUT') @method('PUT') @endif

  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm dark:text-gray-200">Nombre</label>
      <input name="nombre" value="{{ old('nombre', $dep->nombre ?? '') }}" required
             class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
    </div>
    <div>
      <label class="block text-sm dark:text-gray-200">Siglas</label>
      <input name="siglas" value="{{ old('siglas', $dep->siglas ?? '') }}" required
             class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
    </div>
  </div>

  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm dark:text-gray-200">Teléfono</label>
      <input name="telefono" value="{{ old('telefono', $dep->telefono ?? '') }}"
             class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
    </div>
    <div>
      <label class="block text-sm dark:text-gray-200">Dirección</label>
      <input name="direccion" value="{{ old('direccion', $dep->direccion ?? '') }}"
             class="w-full rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
    </div>
  </div>

  <div class="flex gap-2">
    <button class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Guardar</button>
    <a href="{{ route('admin.dependencias.index') }}"
       class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-100">Cancelar</a>
  </div>
</form>
