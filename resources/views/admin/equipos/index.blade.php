{{-- resources/views/inventario/general.blade.php --}}
<x-app-layout> {{-- Ahora extiende x-app-layout directamente --}}
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Inventario General') }} {{-- Puedes usar el headerTitle aquí si lo necesitas --}}
    </h2>
  </x-slot>

  {{--
  <x-ui.section-title
    title="Inventario General"
    subtitle="Listado global de equipos registrados en el sistema"
  />
  --}}

  
  <div class="flex items-center justify-between mb-4">
    <div></div>
    @can('equipos.create')
      <a href="{{ route('admin.equipos.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
        + Registrar un equipo
      </a>
    @endcan
  </div>
  {{-- Incluimos el partial de listado de equipos --}}
  @include('admin.equipos._list_content', compact('equipos','dependencias','tipos','estados','q','dep','tip','est'))
</x-app-layout>