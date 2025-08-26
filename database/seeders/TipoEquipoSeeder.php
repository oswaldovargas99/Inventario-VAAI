<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventarios\TipoEquipo;

class TipoEquipoSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'Laptop','PC de Escritorio','All-in-One','Servidor',
            'Impresora','Multifuncional','Proyector','Monitor',
            'Router','Switch','Access Point','Tablet','Scanner','Otro'
        ] as $nombre) {
            TipoEquipo::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
