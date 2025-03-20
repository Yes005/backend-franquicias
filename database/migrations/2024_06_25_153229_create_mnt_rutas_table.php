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
        Schema::create('mnt_rutas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('uri', 100);
            $table->string('icono', 100);
            $table->boolean('mostrar')->nullable(true);
            $table->integer('orden')->nullable(true);
            $table->unsignedBigInteger('ruta_padre_id')->nullable(true);
            $table->string('nombreUri', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mnt_rutas');
    }
};
