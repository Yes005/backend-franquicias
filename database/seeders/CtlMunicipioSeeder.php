<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CtlMunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ctl_municipio')->upsert([
            ['id' => 1, 'nombre' => 'Ahuachapán Norte', 'id_departamento' => 1],
            ['id' => 2, 'nombre' => 'Ahuachapán Centro', 'id_departamento' => 1],
            ['id' => 3, 'nombre' => 'Ahuachapán Sur', 'id_departamento' => 1],
            ['id' => 4, 'nombre' => 'Santa Ana Oeste', 'id_departamento' => 2],
            ['id' => 5, 'nombre' => 'Santa Ana Este', 'id_departamento' => 2],
            ['id' => 6, 'nombre' => 'Santa Ana Norte', 'id_departamento' => 2],
            ['id' => 7, 'nombre' => 'Santa Ana Centro', 'id_departamento' => 2],
            ['id' => 8, 'nombre' => 'Sonsonate Norte', 'id_departamento' => 3],
            ['id' => 9, 'nombre' => 'Sonsonate Centro', 'id_departamento' => 3],
            ['id' => 10, 'nombre' => 'Sonsonate Este', 'id_departamento' => 3],
            ['id' => 11, 'nombre' => 'Sonsonate Oeste', 'id_departamento' => 3],
            ['id' => 12, 'nombre' => 'Chalatenango Norte', 'id_departamento' => 4],
            ['id' => 13, 'nombre' => 'Chalatenango Centro', 'id_departamento' => 4],
            ['id' => 14, 'nombre' => 'Chalatenango Sur', 'id_departamento' => 4],
            ['id' => 15, 'nombre' => 'La Libertad Norte', 'id_departamento' => 5],
            ['id' => 16, 'nombre' => 'La Libertad Centro', 'id_departamento' => 5],
            ['id' => 17, 'nombre' => 'La Libertad Oeste', 'id_departamento' => 5],
            ['id' => 18, 'nombre' => 'La Libertad Este', 'id_departamento' => 5],
            ['id' => 19, 'nombre' => 'La Libertad Costa', 'id_departamento' => 5],
            ['id' => 20, 'nombre' => 'La Libertad Sur', 'id_departamento' => 5],
            ['id' => 21, 'nombre' => 'San Salvador Norte', 'id_departamento' => 6],
            ['id' => 22, 'nombre' => 'San Salvador Oeste', 'id_departamento' => 6],
            ['id' => 23, 'nombre' => 'San Salvador Este', 'id_departamento' => 6],
            ['id' => 24, 'nombre' => 'San Salvador Centro', 'id_departamento' => 6],
            ['id' => 25, 'nombre' => 'San Salvador Sur', 'id_departamento' => 6],
            ['id' => 26, 'nombre' => 'Cuscatlán Norte', 'id_departamento' => 7],
            ['id' => 27, 'nombre' => 'Cuscatlán Sur', 'id_departamento' => 7],
            ['id' => 28, 'nombre' => 'La Paz Este', 'id_departamento' => 8],
            ['id' => 29, 'nombre' => 'La Paz Centro', 'id_departamento' => 8],
            ['id' => 30, 'nombre' => 'La Paz Oeste', 'id_departamento' => 8],
            ['id' => 31, 'nombre' => 'Cabañas Oeste', 'id_departamento' => 9],
            ['id' => 32, 'nombre' => 'Cabañas Este', 'id_departamento' => 9],
            ['id' => 33, 'nombre' => 'San Vicente Norte', 'id_departamento' => 10],
            ['id' => 34, 'nombre' => 'San Vicente Sur', 'id_departamento' => 10],
            ['id' => 35, 'nombre' => 'Usulután Norte', 'id_departamento' => 11],
            ['id' => 36, 'nombre' => 'Usulután Este', 'id_departamento' => 11],
            ['id' => 37, 'nombre' => 'Usulután Oeste', 'id_departamento' => 11],
            ['id' => 38, 'nombre' => 'San Miguel Norte', 'id_departamento' => 12],
            ['id' => 39, 'nombre' => 'San Miguel Centro', 'id_departamento' => 12],
            ['id' => 40, 'nombre' => 'San Miguel Oeste', 'id_departamento' => 12],
            ['id' => 41, 'nombre' => 'Morazán Norte', 'id_departamento' => 13],
            ['id' => 42, 'nombre' => 'Morazán Sur', 'id_departamento' => 13],
            ['id' => 43, 'nombre' => 'La Unión Norte', 'id_departamento' => 14],
            ['id' => 44, 'nombre' => 'La Unión Sur', 'id_departamento' => 14],
        ], ['id']);
    }
}
