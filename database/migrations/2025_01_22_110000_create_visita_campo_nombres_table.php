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
        Schema::create('mnt_visita_campo_nombres', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('visita_campo_id')->constrained('mnt_visitas_campos')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mnt_visita_campo_nombres');
    }
};
