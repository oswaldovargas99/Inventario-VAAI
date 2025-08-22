<x-layouts.inventario headerTitle="Nueva Dependencia">
  <x-ui.section-title title="Nueva Dependencia" subtitle="Agrega una nueva dependencia" />
  @include('admin.dependencias._form', [
    'route'  => route('admin.dependencias.store'),
    'method' => 'POST',
  ])
</x-layouts.inventario>

