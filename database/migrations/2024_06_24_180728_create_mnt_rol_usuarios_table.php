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
        Schema::create('mnt_rol_usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rol_id')->constrained('ctl_roles');
            $table->foreignId('usuario_id')->constrained('users');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mnt_rol_usuarios');
    }
};
