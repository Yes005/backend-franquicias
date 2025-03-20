<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profile = [
            [
                "cod_colaborador" => "SF1",
                "titulo" => "Auxiliar",
                "cargo" => "Auxiliar",
                "id_distrito" => 110,
                "id_usuario" => 2,
                "firmador" => false,
            ],
            [
                "cod_colaborador" => "SF2",
                "titulo" => "Jefe",
                "cargo" => "Jefe",
                "id_distrito" => 22,
                "id_usuario" => 3,
                "firmador" => false,
            ],
        ];

        $this->loadInsert($profile);
    }

    public function loadInsert($profiles)
    {
        try {
            DB::beginTransaction();

            foreach ($profiles as $profile) {
                DB::table('profile')->upsert([
                    'cod_colaborador' => $profile['cod_colaborador'],
                    'titulo' => $profile['titulo'],
                    'cargo' => $profile['cargo'],
                    'id_distrito' => $profile['id_distrito'],
                    'id_usuario' => $profile['id_usuario'],
                    'firmador' => $profile['firmador'],
                ], 'cod_colaborador');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Error al ejecutar el seeder de perfiles: " . $e->getMessage());
        }
    }
}
