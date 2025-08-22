<x-layouts.inventario headerTitle="Editar Dependencia">
  <x-ui.section-title title="Editar Dependencia" subtitle="Actualiza la información de la dependencia" />
  @include('admin.dependencias._form', [
    'route'  => route('admin.dependencias.update', $dependencia),
    'method' => 'PUT',
    'dep'    => $dependencia,
  ])
</x-layouts.inventario>
