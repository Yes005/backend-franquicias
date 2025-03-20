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
        Schema::table('franquicias_franquicia', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo')->change();
            $table->unsignedBigInteger('estado')->change();
            $table->unsignedBigInteger('usuario_creador_id')->change();

            $table->foreign('tipo')->references('id')->on('ctl_entidad');
            $table->foreign('estado')->references('id')->on('ctl_estados');
            $table->foreign('usuario_creador_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('franquicias', function (Blueprint $table) {
            $table->dropForeign(['tipo']);
            $table->dropForeign(['estado']);
            $table->dropForeign(['usuario_creador_id']);

            $table->string('tipo')->change();
            $table->string('estado')->change();
            $table->integer('usuario_creador_id')->change();
        });
    }
};
