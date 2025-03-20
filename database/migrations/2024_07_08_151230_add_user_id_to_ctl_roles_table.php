<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ctl_roles', function (Blueprint $table) {
            // Agregar la columna id_usuario
            $table->unsignedBigInteger('id_usuario')->nullable();

            // Agregar la restricción de clave externa
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
        });

        // Si es necesario, actualizar los registros existentes para evitar errores de integridad referencial
        DB::table('ctl_roles')->update(['id_usuario' => 1]);

        Schema::table('ctl_roles', function (Blueprint $table) {
            // Asegurar que la columna no sea nula
            $table->unsignedBigInteger('id_usuario')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ctl_roles', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);
            $table->dropColumn('id_usuario');
        });
    }
};
