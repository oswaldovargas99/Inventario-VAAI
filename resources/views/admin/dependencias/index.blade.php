{{-- resources/views/admin/dependencias/index.blade.php --}}
<x-app-layout> {{-- ¡CAMBIO AQUÍ! --}}
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Dependencias') }}
    </h2>
  </x-slot>

    {{--<x-ui.section-title title="Dependencias" subtitle="Catálogo de áreas/centros" />--}}

    @if(session('success'))
      <div class="mb-3 p-3 rounded bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100">
        {{ session('success') }}
      </div>
    @endif
    @if($errors->any())
      <div class="mb-3 p-3 rounded bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100">
        {{ $errors->first() }}
      </div>
    @endif

    <div class="flex justify-between items-center mb-4">
      <form method="GET" class="flex gap-2 w-full max-w-3xl">
        <input type="text" name="q" value="{{ $q }}" placeholder="Buscar nombre, siglas, teléfono"
               class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" />
        <button class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg">Filtrar</button>
      </form>
      <a href="{{ route('admin.dependencias.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Nuevo</a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-gray-100 dark:bg-gray-700">
          <tr>
            <th class="p-2 text-left">Nombre</th>
            <th class="p-2 text-left">Siglas</th>
            <th class="p-2 text-left">Teléfono</th>
            <th class="p-2 text-left">Dirección</th>
            <th class="p-2 text-right">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @forelse($deps as $dep)
            <tr class="border-t border-gray-200 dark:border-gray-700">
              <td class="p-2">{{ $dep->nombre }}</td>
              <td class="p-2">{{ $dep->siglas }}</td>
              <td class="p-2">{{ $dep->telefono ?? '—' }}</td>
              <td class="p-2">{{ $dep->direccion ?? '—' }}</td>
              <td class="p-2 text-right space-x-2">
                <a href="{{ route('admin.dependencias.edit', $dep) }}"
                   class="px-3 py-1 bg-yellow-500 text-white rounded-lg">Editar</a>
                <form action="{{ route('admin.dependencias.destroy', $dep) }}" method="POST" class="inline"
                      onsubmit="return confirm('¿Eliminar dependencia?')">
                  @csrf @method('DELETE')
                  <button class="px-3 py-1 bg-red-600 text-white rounded-lg">Eliminar</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="p-4 text-center text-gray-500 dark:text-gray-400">Sin resultados</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">{{ $deps->onEachSide(1)->links() }}</div>
</x-app-layout>