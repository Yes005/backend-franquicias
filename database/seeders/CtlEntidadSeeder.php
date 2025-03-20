<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CtlEntidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ctl_entidad')->upsert([
            ['id' => 1, 'nombre' => 'Fundación/Instituciones'], 
            ['id' => 2, 'nombre' => 'Oficiales'],
        ],['id']);
    }
}
