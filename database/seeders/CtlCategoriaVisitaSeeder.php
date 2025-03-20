<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CtlCategoriaVisitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [

            [
                'id' => 1,
                'nombre' => 'Sin observaciones',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'nombre' => 'Con observaciones',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],

        ];


        try {
            DB::beginTransaction();


            DB::table('ctl_categoria_visitas')->upsert($categorias, ['id'], ['nombre', 'activo']);


            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }
}
