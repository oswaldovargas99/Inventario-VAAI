<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $perms = [
            'ver inventario',
            'descargar responsiva pdf',
            'descargar facturas_oc',
            'subir pdf',
            'aprobar movimientos',
            'vobo movimientos',
            'editar eliminar',
        ];

        foreach ($perms as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        $admin      = Role::firstOrCreate(['name' => 'Admin']);
        $aprobador  = Role::firstOrCreate(['name' => 'Aprobador']);
        $secretario = Role::firstOrCreate(['name' => 'Secretario']);
        $usuario    = Role::firstOrCreate(['name' => 'Usuario']);

        $usuario->syncPermissions(['ver inventario','descargar responsiva pdf']);

        $aprobador->syncPermissions([
            'ver inventario','descargar responsiva pdf','descargar facturas_oc','subir pdf','aprobar movimientos'
        ]);

        $secretario->syncPermissions([
            'ver inventario','descargar responsiva pdf','vobo movimientos'
        ]);

        $admin->syncPermissions([
            'ver inventario','descargar responsiva pdf','descargar facturas_oc','subir pdf','aprobar movimientos','vobo movimientos','editar eliminar'
        ]);

        if (!User::where('email', 'admin@udg.test')->exists()) {
            $adminUser = User::create([
                'name' => 'Administrador',
                'email' => 'admin@udg.test',
                'password' => bcrypt('julioC123'),
            ]);
            $adminUser->assignRole('Admin');
        }
    }
}
