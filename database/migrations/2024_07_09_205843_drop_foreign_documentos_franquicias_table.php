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
        Schema::table('franquicias_documentosfranquicia', function (Blueprint $table) {
            $table->dropForeign('franquicias_document_franquicia_id_debee987_fk_franquici');
        });

        Schema::table('franquicias_documentosfranquicia', function (Blueprint $table) {
            $table->unsignedInteger('franquicia_id')->nullable()->change();
            $table->foreign('franquicia_id')->references('id')->on('franquicias_franquicia')->onDelete('cascade');

            $table->longText('descripcion')->nullable()->change();
            $table->boolean('activo')->default(true)->change();

            $table->unsignedBigInteger('usuario_creador_id')->nullable();
            $table->foreign('usuario_creador_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('franquicias_documentosfranquicia', function (Blueprint $table) {
            $table->dropForeign(['franquicia_id']);
            
        });

        Schema::table('franquicias_documentosfranquicia', function (Blueprint $table) {
            $table->dropForeign(['usuario_creador_id']);

            $table->dropColumn('usuario_creador_id');
            $table->longText('descripcion')->nullable(false)->change();
            $table->boolean('activo')->nullable(false)->change();

            $table->integer('franquicia_id')->nullable(false)->change();

            $table->foreign('franquicia_id', 'franquicias_document_franquicia_id_debee987_fk_franquici')
                ->references('id')->on('franquicias_franquicia_bckp');
        });
    }
};
