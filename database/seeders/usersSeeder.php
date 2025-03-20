<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class usersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                "id" => 1,
                "name" => "Admin",
                "email" => "admin@root.com",
                "password" => bcrypt("admin_123"),
                "email_verified_at" => Carbon::now(),
                "created_at" => Carbon::now(),
            ],
            [
                "id" => 2,
                "name" => "Auxiliar",
                "email" => "auxiliar@innovacion.com",
                "password" => bcrypt("admin_123"),
                "email_verified_at" => Carbon::now(),
                "created_at" => Carbon::now(),
            ],
            [
                "id" => 3,
                "name" => "Jefe",
                "email" => "jefe@innovacion.com",
                "password" => bcrypt("admin_123"),
                "email_verified_at" => Carbon::now(),
                "created_at" => Carbon::now(),
            ],
        ];

        $this->loadInsert($user);
    }

    private function getRolByName($name)
    {
        return DB::table('ctl_roles')->where('nombre', $name)->first();
    }

    public function loadInsert($users)
    {
        try{
            DB::beginTransaction();

            foreach($users as $user){
                DB::table('users')->upsert([
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => $user['password'],
                    'email_verified_at' => $user['email_verified_at'],
                    'created_at' => $user['created_at'],
                ], 'id');
            }
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Error al ejecutar el seeder de usuarios: " . $e->getMessage());
        }
    }
}
