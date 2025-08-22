<x-layouts.inventario headerTitle="Editar Usuario">
  <x-ui.section-title title="Editar Usuario" subtitle="Actualiza los datos del usuario" />

  @include('admin.users._form', [
    'route'  => route('admin.users.update', $user),
    'method' => 'PUT',
    'user'   => $user,
  ])
</x-layouts.inventario>
