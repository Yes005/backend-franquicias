<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Catalogos\CtlEntidad;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            //usersSeeder::class,
            CtlRolesSeeder::class,
            CtlPermisosSeeder::class,
            MntRolPermisosSeeder::class,
            //MntRolUsuariosSeeder::class,
            RutasSeeder::class,
            CtlDepartamentoSeeder::class,
            CtlMunicipioSeeder::class,
            CtlDistritoSeeder::class,
            CtlEntidadSeeder::class,
            CtlEstadosSeeder::class,
            //ProfileSeeder::class,
            CtlClasificacionSeeder::class,
            CtlCategoriaVisitaSeeder::class,
        ]);
    }
}
