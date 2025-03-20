<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CtlClasificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clasificaciones = 
        [
            [
            'id' => 1,
            'nombre' => 'Colaboración en el proceso de franquicia', 
            'puntaje_maximo' => 10,
            'created_at' => now()
            ],

            [
            'id' => 2,
            'nombre' => 'Manejo adecuado de la documentación', 
            'puntaje_maximo' => 10,
            'created_at' => now()],

             [
            'id' => 3,
            'nombre' => 'Uso adecuado de la franquicia', 
            'puntaje_maximo' => 10,
            'created_at' => now()
            ],

             [
             'id' => 4,
             'nombre' => 'Beneficio social', 
             'puntaje_maximo' => 10,
             'created_at' => now()],
             
        ];
        $this->loadInsert($clasificaciones);
    }

    public function loadInsert($permisos)
    {
        try{
            DB::beginTransaction();
            foreach ($permisos as $permiso) {
                DB::table('ctl_clasificacion')->upsert([
                    'id' => $permiso['id'],
                    'nombre' => $permiso['nombre'],
                    'puntaje_maximo' => $permiso['puntaje_maximo'],
                    'created_at' => $permiso['created_at'],
                ], 'id');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Error al ejecutar el seeder de Clasificacion" . $e->getMessage());
        }
    }
}
