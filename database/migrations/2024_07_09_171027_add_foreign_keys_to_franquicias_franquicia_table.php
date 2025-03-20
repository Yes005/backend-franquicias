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
        Schema::table('franquicias_franquicia', function (Blueprint $table) {
            // Agregar nuevas claves foráneas
            $table->foreign('aduana_id')
                ->references('id')->on('franquicias_aduana')
                ->onDelete('cascade');

            $table->foreign('factura_comercial_id')
                ->references('id')->on('franquicias_facturacomercial')
                ->onDelete('cascade');

            $table->foreign('institucion_id')
                ->references('id')->on('franquicias_institucion')
                ->onDelete('cascade');

            $table->foreign('oficial_id')
                ->references('id')->on('franquicias_oficial')
                ->onDelete('cascade');

            $table->foreign('clase_id')
                ->references('id')->on('franquicias_clase')
                ->onDelete('cascade');

            $table->foreign('corrector_id')
                ->references('id')->on('auth_user')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('franquicias_franquicia', function (Blueprint $table) {
            // Eliminar las claves foráneas agregadas
            $table->dropForeign(['aduana_id']);
            $table->dropForeign(['factura_comercial_id']);
            $table->dropForeign(['institucion_id']);
            $table->dropForeign(['oficial_id']);
            $table->dropForeign(['clase_id']);
            $table->dropForeign(['corrector_id']);
        });
    }
};
