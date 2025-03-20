<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CtlRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                "id" => 1,
                "nombre" => "Administrador",
                "activo" => true,
                'id_usuario' => 1,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 2,
                "nombre" => "Auxiliar",
                'id_usuario' => 1,
                "activo" => true,
                "created_at" => Carbon::now()
            ],
            [
                "id" => 3,
                "nombre" => "Jefe",
                'id_usuario' => 1,
                "activo" => true,
                "created_at" => Carbon::now()
            ],
        ];

        $this->loadInsert($roles);
    }

    public function loadInsert($roles)
    {
        try {
            DB::beginTransaction();
            foreach ($roles as $rol) {
                DB::table('ctl_roles')->upsert([
                    'id' => $rol['id'],
                    'nombre' => $rol['nombre'],
                    'id_usuario' => $rol['id_usuario'],
                    'activo' => $rol['activo'],
                    'created_at' => $rol['created_at'],
                ], 'id');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Error al ejecutar el seeder de roles: " . $e->getMessage());
        }
    }
}
