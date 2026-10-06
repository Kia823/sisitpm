<?php

namespace Database\Seeders;

use App\Models\ActivoFijo;
use App\Models\Ambiente;
use App\Models\Carrera;
use App\Models\Categoria;
use App\Models\FuenteFinanciamiento;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder as BaseSeeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends BaseSeeder
{
    public function run(): void
    {
        // Limpiar tablas respetando llaves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('verificaciones_fisicas')->truncate();
        DB::table('actas_baja')->truncate();
        DB::table('actas_transferencia')->truncate();
        DB::table('historial_titulares')->truncate();
        DB::table('item_usuario')->truncate();
        ActivoFijo::truncate();
        Item::truncate();
        Ambiente::truncate();
        Categoria::truncate();
        FuenteFinanciamiento::truncate();
        User::truncate();
        Carrera::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ============================================================
        // 1. CARRERAS
        // ============================================================
        $carreras = [
            ['codigo' => 'SIF', 'nombre' => 'Sistemas Informáticos'],
            ['codigo' => 'INA', 'nombre' => 'Industrias de Alimentos'],
            ['codigo' => 'GTR', 'nombre' => 'Gastronomía'],
            ['codigo' => 'MAZ', 'nombre' => 'Mecánica Automotriz'],
            ['codigo' => 'MEI', 'nombre' => 'Mecánica Industrial'],
            ['codigo' => 'ELC', 'nombre' => 'Electrónica'],
            // No es una carrera: agrupa los espacios que no pertenecen a
            // ninguna escuela (rectorado, secretaría, almacén, biblioteca).
            ['codigo' => 'ADM', 'nombre' => 'Unidades Administrativas'],
        ];

        $carreraIds = [];
        foreach ($carreras as $carrera) {
            $fila = Carrera::updateOrCreate(['codigo' => $carrera['codigo']], $carrera);
            $carreraIds[$carrera['codigo']] = $fila->id_carrera;
        }

        $sifId = Carrera::where('codigo', 'SIF')->value('id_carrera');

        // ============================================================
        // 2. USUARIOS — con email, permiso de verificar e ítem asignado
        // ============================================================
        // Roles: ADMINISTRADOR, INVENTARIADOR, DOCENTE_CUSTODIO, JEFE_CARRERA, RECTOR

        $users = [
            // ------------------------------------------------------------
            // ADMINISTRADOR — siempre puede verificar (no necesita el flag)
            // ------------------------------------------------------------
            [
                'ci'               => '4756925',
                'nombre_completo'  => 'Ana Lía Zapana Cortez',
                'email'            => 'admin@itpm.edu.bo',
                'password'         => Hash::make('admin123*'),
                'cargo'            => 'Administradora',
                'unidad'           => 'Dirección Administrativa',
                'rol'              => 'ADMINISTRADOR',
                'estado'           => 'ACTIVO',
                'id_carrera'       => null,
                'puede_verificar'  => true,  // ⭐ admin siempre verifica
                'items'            => ['91'],
            ],

            // ------------------------------------------------------------
            // INVENTARIADOR — por defecto SÍ puede verificar
            // ------------------------------------------------------------
            [
                'ci'               => '4243543',
                'nombre_completo'  => 'Juan Carlos Osco Mamani',
                'email'            => 'inventariador@itpm.edu.bo',
                'password'         => Hash::make('inventario123'),
                'cargo'            => 'Inventariador',
                'unidad'           => 'Departamento de Activos',
                'rol'              => 'INVENTARIADOR',
                'estado'           => 'ACTIVO',
                'id_carrera'       => null,
                'puede_verificar'  => true,
                'items'            => ['92'],
            ],

            // ------------------------------------------------------------
            // DOCENTE CUSTODIO — por defecto NO puede verificar
            // (el admin debe activarle el permiso)
            // ------------------------------------------------------------
            [
                'ci'               => '3451328',
                'nombre_completo'  => 'Patricia Regina Flores Chuquimia',
                'email'            => 'patricia.mamani@itpm.edu.bo',
                'password'         => Hash::make('docente123'),
                'cargo'            => 'Docente Custodio',
                'unidad'           => 'Laboratorio 3',
                'rol'              => 'DOCENTE_CUSTODIO',
                'estado'           => 'ACTIVO',
                'id_carrera'       => $sifId,
                'puede_verificar'  => false,  // ⭐ requiere activación
                'items'            => ['131'],
            ],
            [
                'ci'               => '6032467',
                'nombre_completo'  => 'Jhony Chavez Quispe',
                'email'            => 'jhony.chavez@itpm.edu.bo',
                'password'         => Hash::make('docente123'),
                'cargo'            => 'Docente Custodio',
                'unidad'           => 'Laboratorio 3',
                'rol'              => 'DOCENTE_CUSTODIO',
                'estado'           => 'ACTIVO',
                'id_carrera'       => $sifId,
                'puede_verificar'  => false,
                'items'            => ['115'],
            ],

            // ------------------------------------------------------------
            // JEFE DE CARRERA — por defecto NO puede verificar
            // ------------------------------------------------------------
            [
                'ci'               => '4286280',
                'nombre_completo'  => 'Eliza Nina Coronel',
                'email'            => 'luis.morales@itpm.edu.bo',
                'password'         => Hash::make('jefe123'),
                'cargo'            => 'Jefe de Carrera de Sistemas Informáticos',
                'unidad'           => 'Escuela de Sistemas Informáticos',
                'rol'              => 'JEFE_CARRERA',
                'estado'           => 'ACTIVO',
                'id_carrera'       => $sifId,
                'puede_verificar'  => false,
                'items'            => ['124'],
            ],

            // ------------------------------------------------------------
            // RECTOR — nunca verifica
            // ------------------------------------------------------------
            [
                'ci'               => '4960313',
                'nombre_completo'  => 'Jimmy Ovidio Sirpa Choque',
                'email'            => 'rector@itpm.edu.bo',
                'password'         => Hash::make('rector123'),
                'cargo'            => 'Rector',
                'unidad'           => 'Rectorado',
                'rol'              => 'RECTOR',
                'estado'           => 'ACTIVO',
                'id_carrera'       => null,
                'puede_verificar'  => false,
                'items'            => ['88'],
            ],
        ];

        $itemsPorUsuario = [];

        foreach ($users as $user) {
            $items = $user['items'] ?? [];
            unset($user['items']);

            $fila = User::updateOrCreate(['ci' => $user['ci']], $user);
            $itemsPorUsuario[$fila->id_usuario] = $items;
        }

        // ============================================================
        // 3. AMBIENTES
        // ============================================================
// Cada ambiente indica a qué grupo pertenece. Los laboratorios son
        // de Sistemas Informáticos; el almacén y las oficinas, de Unidades
        // Administrativas.
        $ambientes = [
            ['codigo' => 'LAB-1', 'nombre' => 'Laboratorio 1', 'bloque' => 'A', 'piso' => 1, 'carrera' => 'SIF'],
            ['codigo' => 'LAB-2', 'nombre' => 'Laboratorio 2', 'bloque' => 'A', 'piso' => 1, 'carrera' => 'SIF'],
            ['codigo' => 'LAB-3', 'nombre' => 'Laboratorio 3', 'bloque' => 'A', 'piso' => 1, 'carrera' => 'SIF'],
            ['codigo' => 'RED-1', 'nombre' => 'Redes', 'bloque' => 'B', 'piso' => 1, 'carrera' => 'SIF'],
            ['codigo' => 'REC-1', 'nombre' => 'Rectorado', 'bloque' => 'A', 'piso' => 2, 'carrera' => 'ADM'],
            ['codigo' => 'SEC-1', 'nombre' => 'Secretaría General', 'bloque' => 'A', 'piso' => 2, 'carrera' => 'ADM'],
            ['codigo' => 'ADM-1', 'nombre' => 'Dirección Administrativa', 'bloque' => 'A', 'piso' => 2, 'carrera' => 'ADM'],
            ['codigo' => 'ALM-1', 'nombre' => 'Almacén', 'bloque' => 'C', 'piso' => 1, 'carrera' => 'ADM'],
            ['codigo' => 'BIB-1', 'nombre' => 'Biblioteca', 'bloque' => 'B', 'piso' => 1, 'carrera' => 'ADM'],
        ];

        foreach ($ambientes as $ambiente) {
            Ambiente::updateOrCreate(
                ['codigo' => $ambiente['codigo']],
                [
                    'nombre'     => $ambiente['nombre'],
                    'bloque'     => $ambiente['bloque'],
                    'piso'       => $ambiente['piso'],
                    'id_carrera' => $carreraIds[$ambiente['carrera']],
                ]
            );
        }

        // ============================================================
        // 4. CATEGORÍAS
        // ============================================================
        $categorias = [
            ['codigo' => 'EQP-INF', 'nombre' => 'Equipos Informáticos', 'descripcion' => 'Equipos de cómputo y accesorios'],
            ['codigo' => 'EQP-ELC', 'nombre' => 'Equipos Electrónicos', 'descripcion' => 'Equipos electrónicos y componentes'],
            ['codigo' => 'MOB-URB', 'nombre' => 'Mobiliario', 'descripcion' => 'Mobiliario y enseres'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::updateOrCreate(['codigo' => $categoria['codigo']], $categoria);
        }

        // ============================================================
        // 5. FUENTES DE FINANCIAMIENTO
        // ============================================================
        $fuentes = [
            ['codigo' => 'GD', 'nombre' => 'Gobierno Departamental'],
            ['codigo' => 'GM', 'nombre' => 'Gobierno Municipal'],
            ['codigo' => 'GN', 'nombre' => 'Gobierno Nacional'],
            ['codigo' => 'PSP', 'nombre' => 'Proyecto Socio Productivo'],
            ['codigo' => 'ADQ', 'nombre' => 'Adquisición'],
            ['codigo' => 'OTR', 'nombre' => 'Otros'],
            ['codigo' => 'RPC', 'nombre' => 'Recursos Propios por Carrera'],
            ['codigo' => 'RPI', 'nombre' => 'Recursos Propios Institucionales'],
        ];

        foreach ($fuentes as $fuente) {
            FuenteFinanciamiento::updateOrCreate(['nombre' => $fuente['nombre']], $fuente);
        }

        // ============================================================
        // 6. ITEMS — Plazas institucionales. Sobreviven a los cambios
        //    de titular y pueden tener 2, 3 o más custodios.
        // ============================================================
        // Cada ítem pertenece a un ambiente: sus custodios son quienes
        // firman la liberación de ese ambiente al cierre de la gestión.
        $items = [
            ['numero_item' => '91',  'descripcion' => 'Administradora',                            'unidad' => 'Dirección Administrativa', 'carrera' => null, 'ambiente' => 'ADM-1'],
            ['numero_item' => '92',  'descripcion' => 'Inventariador',                            'unidad' => 'Departamento de Activos',  'carrera' => null, 'ambiente' => 'ALM-1'],
            ['numero_item' => '131', 'descripcion' => 'Docente Custodio - Laboratorio 3',         'unidad' => 'Laboratorio 3',           'carrera' => 'SIF', 'ambiente' => 'LAB-3'],
            ['numero_item' => '115', 'descripcion' => 'Docente Custodio - Laboratorio 3',         'unidad' => 'Laboratorio 3',           'carrera' => 'SIF', 'ambiente' => 'LAB-3'],
            ['numero_item' => '124', 'descripcion' => 'Jefe de Carrera de Sistemas Informáticos', 'unidad' => 'Escuela de Sistemas Informáticos', 'carrera' => 'SIF', 'ambiente' => null],
            ['numero_item' => '88',  'descripcion' => 'Rector',                                   'unidad' => 'Rectorado',               'carrera' => null, 'ambiente' => 'REC-1'],
        ];

        $ambienteIds = [];
        foreach (Ambiente::all() as $ambiente) {
            $ambienteIds[$ambiente->codigo] = $ambiente->id_ambiente;
        }

        $itemIds = [];
        foreach ($items as $item) {
            $fila = Item::create([
                'numero_item' => $item['numero_item'],
                'descripcion' => $item['descripcion'],
                'unidad' => $item['unidad'],
                'id_carrera' => $item['carrera'] ? ($carreraIds[$item['carrera']] ?? null) : null,
                'id_ambiente' => $item['ambiente'] ? ($ambienteIds[$item['ambiente']] ?? null) : null,
                'estado' => 'VACANTE',
            ]);
            $itemIds[$item['numero_item']] = $fila->id_item;
        }

        // Cada ítem queda a nombre de su titular. Si un docente renuncia,
        // solo se cambian sus datos: el ítem y sus activos se mantienen.
        foreach ($itemsPorUsuario as $idUsuario => $numeros) {
            foreach ($numeros as $numero) {
                Item::find($itemIds[$numero])->custodios()->syncWithoutDetaching([
                    $idUsuario => [
                        'tipo' => 'TITULAR',
                        'fecha_inicio' => '2026-01-01',
                        'fecha_fin' => null,
                    ],
                ]);
            }
        }

foreach (Item::all() as $fila) {
            $fila->recalcularEstado();
        }

        // ============================================================
        // 7. INVENTARIO
        // ============================================================
        // El sistema arranca sin activos: se dan de alta uno por uno desde
        // el inventario, con su código, ambiente, custodio y fuente. Solo
        // queda el catálogo de categorías con el que se clasificarán.
        Categoria::updateOrCreate(
            ['codigo' => 'MAT-CONS'],
            ['nombre' => 'Material de Consumo', 'descripcion' => 'Escobas, papeleras, engrampadoras, perforadoras']
        );
    }
}
