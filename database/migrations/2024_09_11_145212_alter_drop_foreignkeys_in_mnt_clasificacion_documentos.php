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
        Schema::table('mnt_clasificacion_documentos', function (Blueprint $table) {
            //Elimar claves foráneas

            $table->dropForeign(['clasificacion_franquicia_id']);

            // Eliminar las columnas
            $table->dropColumn(['clasificacion_franquicia_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mnt_clasificacion_documentos', function (Blueprint $table) {
            //
        });
    }
};
