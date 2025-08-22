<x-layouts.inventario headerTitle="Nuevo Usuario">
  <x-ui.section-title title="Nuevo Usuario" subtitle="Captura los datos del usuario" />

  @include('admin.users._form', [
    'route'  => route('admin.users.store'),
    'method' => 'POST',
  ])
</x-layouts.inventario>
