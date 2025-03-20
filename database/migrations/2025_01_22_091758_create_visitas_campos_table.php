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
        Schema::create('mnt_visitas_campos', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_seguimiento');
            $table->integer('correlativo');
            $table->unsignedInteger('entidad_id');
            $table->date('fecha_visita');
            $table->foreignId('categoria_visita_id')->constrained('ctl_categoria_visitas');
            $table->longText('detalle');
            $table->foreignId('estado_id')->constrained('ctl_estados');
            $table->timestamps();

            $table->foreign('entidad_id')->references('id')->on('franquicias_franquicia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mnt_visitas_campos');
    }
};
