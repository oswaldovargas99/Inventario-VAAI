<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Limpia caché de permisos/roles para evitar “fantasmas”
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // Permisos existentes (tus nombres en español)
        $permsBase = [
            'ver inventario',
            'descargar responsiva pdf',
            'descargar facturas_oc',
            'subir pdf',
            'aprobar movimientos',
            'vobo movimientos',
            'editar eliminar',
        ];

        // NUEVOS permisos para módulo de Equipos (usaremos naming consistente tipo recurso)
        $permsEquipos = [
            'equipos.view',
            'equipos.create',
            'equipos.update',
            'equipos.delete',
            'movimientos.view',
            'movimientos.create',
            'movimientos.edit',
            'movimientos.delete',
            'movimientos.approve',
        ];

        // Crea/asegura todos los permisos
        foreach (array_merge($permsBase, $permsEquipos) as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
        }

        // Crea/asegura roles
        $admin      = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $aprobador  = Role::firstOrCreate(['name' => 'Aprobador', 'guard_name' => 'web']);
        $secretario = Role::firstOrCreate(['name' => 'Secretario', 'guard_name' => 'web']);
        $usuario    = Role::firstOrCreate(['name' => 'Usuario', 'guard_name' => 'web']);

        // Asignación por rol (matriz)
        $usuario->syncPermissions([
            'ver inventario',
            'descargar responsiva pdf',
            // Sin permisos CRUD de equipos
        ]);

        $aprobador->syncPermissions([
            'ver inventario',
            'descargar responsiva pdf',
            'descargar facturas_oc',
            'subir pdf',
            'aprobar movimientos',
            // Equipos: puede ver/crear/actualizar (no delete)
            'equipos.view',
            'equipos.create',
            'equipos.update',
            
            'movimientos.view',
            'movimientos.create',
            'movimientos.edit',
            'movimientos.delete',
            'movimientos.approve'
        ]);

        $secretario->syncPermissions([
            'ver inventario',
            'descargar responsiva pdf',
            'vobo movimientos',
            // Equipos: puede ver/crear/actualizar (no delete)
            'equipos.view',
            'equipos.create',
            'equipos.update',

            'movimientos.view',
            'movimientos.create',
            'movimientos.edit',
            'movimientos.delete',
            'movimientos.approve'
        ]);

        $admin->syncPermissions([
            'ver inventario',
            'descargar responsiva pdf',
            'descargar facturas_oc',
            'subir pdf',
            'aprobar movimientos',
            'vobo movimientos',
            'editar eliminar',
            // Equipos: full
            'equipos.view',
            'equipos.create',
            'equipos.update',
            'equipos.delete',

            'movimientos.view',
            'movimientos.create',
            'movimientos.edit',
            'movimientos.delete',
            'movimientos.approve'
        ]);

        // Usuario Admin inicial (idempotente)
        if (!User::where('email', 'admin@udg.com')->exists()) {
            $adminUser = User::create([
                'name'     => 'Administrador',
                'email'    => 'admin@udg.mx',
                'password' => bcrypt('julioC123'),
            ]);
            $adminUser->assignRole('Admin');
        }

        // Vuelve a limpiar la caché por cualquier cambio durante el seeding
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
