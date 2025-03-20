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
        Schema::table('mnt_clasificacion_franquicia', function (Blueprint $table) {
             // Eliminar claves foráneas
             $table->dropForeign(['institucion_id']);
             $table->dropForeign(['oficial_id']);
 
             // Eliminar las columnas
             $table->dropColumn(['institucion_id', 'oficial_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mnt_clasificacion_franquicia', function (Blueprint $table) {
             // Restaurar las columnas
             $table->integer('institucion_id')->nullable();
             $table->integer('oficial_id')->nullable();
 
             // Restaurar las claves foráneas
             $table->foreign('institucion_id')->references('id')->on('franquicias_institucion');
             $table->foreign('oficial_id')->references('id')->on('franquicias_oficial');
        });
    }
};
