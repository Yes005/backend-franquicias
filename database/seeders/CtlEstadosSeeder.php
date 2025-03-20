<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CtlEstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ctl_estados')->upsert([
            ['id' => 1, 'nombre' => 'Borrador'],
            ['id' => 2, 'nombre' => 'Revisión'],
            ['id' => 3, 'nombre' => 'Observada'],
            ['id' => 4, 'nombre' => 'Solventada'],
            ['id' => 5, 'nombre' => 'Anulada'],
            ['id' => 6, 'nombre' => 'Aprobada'],
            ['id' => 7, 'nombre' => 'Firmada'],
            ['id' => 8, 'nombre' => 'Finalizado'],
        ],['id']);
    }
}
