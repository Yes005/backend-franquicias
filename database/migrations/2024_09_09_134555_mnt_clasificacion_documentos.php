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
        Schema::create('mnt_clasificacion_documentos', function (Blueprint $table) {
            $table->id();
            $table->string('archivo',100);
            $table->foreignId('usuario_creador_id')->constrained('users');
            $table->foreignId('clasificacion_franquicia_id')->constrained('mnt_clasificacion_franquicia');
            $table->string('comentario', 500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mnt_clasificacion_documentos');
    }
};
