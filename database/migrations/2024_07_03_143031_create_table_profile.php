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
        Schema::create('profile', function (Blueprint $table) {
            $table->id();
            $table->string('cod_colaborador')->nullable(false);
            $table->string('titulo')->nullable(false);
            $table->string('cargo')->nullable(false);
            $table->unsignedBigInteger('id_distrito')->nullable(false);
            $table->unsignedBigInteger('id_usuario')->nullable(false);
            $table->boolean('firmador')->default(false);
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_distrito')->references('id')->on('ctl_distrito')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile');
    }
};
