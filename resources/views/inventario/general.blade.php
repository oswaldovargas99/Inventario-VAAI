{{-- resources/views/inventario/general.blade.php --}}

<x-layouts.inventario headerTitle="Inventario General">
  <x-ui.section-title
    title="Inventario General"
    subtitle="Listado global de equipos registrados en el sistema"
  />
  <div class="flex items-center justify-between mb-4">
    <div></div>
    @can('equipos.create')
      <a href="{{ route('admin.equipos.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
        + Registrar un equipo
      </a>
    @endcan
  </div>
  @include('admin.equipos._list_content', compact('equipos','dependencias','tipos','estados','q','dep','tip','est'))
</x-layouts.inventario>