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
        Schema::create('mnt_clasificacion_franquicia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clasificacion_id');
            $table->integer('institucion_id')->nullable();
            $table->integer('oficial_id')->nullable();
            $table->unsignedInteger('franquicia_id');
            $table->integer('puntaje');
            $table->timestamps();

            // Relaciones
            $table->foreign('clasificacion_id')->references('id')->on('ctl_clasificacion');
            $table->foreign('institucion_id')->references('id')->on('franquicias_institucion');
            $table->foreign('oficial_id')->references('id')->on('franquicias_oficial');
            $table->foreign('franquicia_id')->references('id')->on('franquicias_franquicia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mnt_clasificacion_franquicia');
    }
};
