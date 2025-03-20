<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('franquicias_institucion', function (Blueprint $table) {
            $table->string('representante_legal',150)->nullable();
            $table->date('fecha_inicio_junta_directiva')->nullable();
            $table->date('fecha_fin_junta_directiva')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('franquicias_institucion', function (Blueprint $table) {
            $table->dropColumn('representante_legal');
            $table->dropColumn('fecha_inicio_junta_directiva');
            $table->dropColumn('fecha_fin_junta_directiva');
        });
    }
};
