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
        Schema::create('mnt_rutas_permiso', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ruta_id');
            $table->foreign('ruta_id')->references('id')->on('mnt_rutas');

            $table->unsignedBigInteger('permiso_id');
            $table->foreign('permiso_id')->references('id')->on('ctl_permisos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mnt_rutas_permiso');
    }
};
