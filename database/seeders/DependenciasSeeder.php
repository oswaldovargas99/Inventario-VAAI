<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventarios\Dependencia;

class DependenciasSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'siglas'     => 'CUCS',
                'nombre'     => 'Centro Universitario de Ciencias de la Salud',
                'telefono'   => '33 0000 1001',
                'direccion'  => 'Av. Salud 100, CP 44100',
                'colonia'    => 'Independencia',
                'municipio'  => 'Guadalajara',
                'estado'     => 'Jalisco',
                'pais'       => 'México',
            ],
            [
                'siglas'     => 'CUCEI',
                'nombre'     => 'Centro Universitario de Ciencias Exactas e Ingenierías',
                'telefono'   => '33 0000 1002',
                'direccion'  => 'Av. Ingeniería 200, CP 44420',
                'colonia'    => 'Universitaria',
                'municipio'  => 'Guadalajara',
                'estado'     => 'Jalisco',
                'pais'       => 'México',
            ],
            [
                'siglas'     => 'CUCEA',
                'nombre'     => 'Centro Universitario de Ciencias Económico Administrativas',
                'telefono'   => '33 0000 1003',
                'direccion'  => 'Av. Economía 300, CP 45110',
                'colonia'    => 'Jardines',
                'municipio'  => 'Zapopan',
                'estado'     => 'Jalisco',
                'pais'       => 'México',
            ],
            [
                'siglas'     => 'CUAAD',
                'nombre'     => 'Centro Universitario de Arte, Arquitectura y Diseño',
                'telefono'   => '33 0000 1004',
                'direccion'  => 'Av. Artes 400, CP 44280',
                'colonia'    => 'Centro',
                'municipio'  => 'Guadalajara',
                'estado'     => 'Jalisco',
                'pais'       => 'México',
            ],
            [
                'siglas'     => 'CUAltos',
                'nombre'     => 'Centro Universitario de los Altos',
                'telefono'   => '37 8000 1005',
                'direccion'  => 'Av. Altos 500, CP 47600',
                'colonia'    => 'Las Huertas',
                'municipio'  => 'Tepatitlán de Morelos',
                'estado'     => 'Jalisco',
                'pais'       => 'México',
            ],
            [
                'siglas'     => 'CUCiénega',
                'nombre'     => 'Centro Universitario de la Ciénega',
                'telefono'   => '39 2000 1006',
                'direccion'  => 'Av. Ciénega 600, CP 47800',
                'colonia'    => 'Centro',
                'municipio'  => 'Ocotlán',
                'estado'     => 'Jalisco',
                'pais'       => 'México',
            ],
            [
                'siglas'     => 'CULagos',
                'nombre'     => 'Centro Universitario de los Lagos',
                'telefono'   => '47 4000 1007',
                'direccion'  => 'Av. Lagos 700, CP 47460',
                'colonia'    => 'Centro',
                'municipio'  => 'Lagos de Moreno',
                'estado'     => 'Jalisco',
                'pais'       => 'México',
            ],
            [
                'siglas'     => 'CUCosta',
                'nombre'     => 'Centro Universitario de la Costa',
                'telefono'   => '32 2000 1008',
                'direccion'  => 'Av. Costa 800, CP 48300',
                'colonia'    => 'Las Glorias',
                'municipio'  => 'Puerto Vallarta',
                'estado'     => 'Jalisco',
                'pais'       => 'México',
            ],
            [
                'siglas'     => 'CUTonalá',
                'nombre'     => 'Centro Universitario de Tonalá',
                'telefono'   => '33 0000 1009',
                'direccion'  => 'Av. Tonalá 900, CP 45400',
                'colonia'    => 'Centro',
                'municipio'  => 'Tonalá',
                'estado'     => 'Jalisco',
                'pais'       => 'México',
            ],
            [
                'siglas'     => 'CUCBA',
                'nombre'     => 'Centro Universitario de Ciencias Biológicas y Agropecuarias',
                'telefono'   => '33 0000 1010',
                'direccion'  => 'Km 15.5 Carretera a Nogales, CP 45200',
                'colonia'    => 'Las Agujas',
                'municipio'  => 'Zapopan',
                'estado'     => 'Jalisco',
                'pais'       => 'México',
            ],
            [
                'siglas'     => 'REC',
                'nombre'     => 'Rectoría General',
                'telefono'   => '33 0000 1011',
                'direccion'  => 'Av. Universidad 1000, CP 44170',
                'colonia'    => 'Centro',
                'municipio'  => 'Guadalajara',
                'estado'     => 'Jalisco',
                'pais'       => 'México',
            ],
            [
                'siglas'     => 'DTI',
                'nombre'     => 'Dirección de Tecnologías de Información',
                'telefono'   => '33 0000 1012',
                'direccion'  => 'Av. Tecnología 1200, CP 44170',
                'colonia'    => 'Centro',
                'municipio'  => 'Guadalajara',
                'estado'     => 'Jalisco',
                'pais'       => 'México',
            ],
            [
                'siglas'     => 'SA',
                'nombre'     => 'Secretaría Académica',
                'telefono'   => '33 0000 1013',
                'direccion'  => 'Av. Académica 1300, CP 44170',
                'colonia'    => 'Centro',
                'municipio'  => 'Guadalajara',
                'estado'     => 'Jalisco',
                'pais'       => 'México',
            ],
            [
                'siglas'     => 'CGTI',
                'nombre'     => 'Coordinación General de Tecnologías de Información',
                'telefono'   => '33 0000 1014',
                'direccion'  => 'Av. Sistemas 1400, CP 44170',
                'colonia'    => 'Centro',
                'municipio'  => 'Guadalajara',
                'estado'     => 'Jalisco',
                'pais'       => 'México',
            ],
        ];

        foreach ($rows as $r) {
            // Usa 'siglas' como clave natural para evitar duplicados
            Dependencia::updateOrCreate(
                ['siglas' => $r['siglas']],
                [
                    'nombre'    => $r['nombre'],
                    'telefono'  => $r['telefono'],
                    'direccion' => $r['direccion'],
                    'colonia'   => $r['colonia'],
                    'municipio' => $r['municipio'],
                    'estado'    => $r['estado'],
                    'pais'      => $r['pais'],
                ]
            );
        }
    }
}
