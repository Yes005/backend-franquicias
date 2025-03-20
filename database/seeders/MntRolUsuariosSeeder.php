<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MntRolUsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRol = [
            [
                "id" => 1,
                'rol_id' => 1,
                'usuario_id' => 1,
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 2,
                'rol_id' => 2,
                'usuario_id' => 2,
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 3,
                'rol_id' => 3,
                'usuario_id' => 3,
                "activo" => true,
                "created_at" => Carbon::now()
            ]
        ];

        $this->loadInsert($userRol);
    }

    public function loadInsert($userRol)
    {
        try {
            DB::beginTransaction();
            foreach ($userRol as $ur) {
                DB::table('mnt_rol_usuarios')->upsert([
                    'id' => $ur['id'],
                    'rol_id' => $ur['rol_id'],
                    'usuario_id' => $ur['usuario_id'],
                    'activo' => $ur['activo'],
                    'created_at' => $ur['created_at'],
                ], 'id');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Error al ejecutar el seeder de User/Roles: " . $e->getMessage());
        }
    }
}
