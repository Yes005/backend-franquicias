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
        Schema::table('mnt_clasificacion_documentos', function (Blueprint $table) {
            $table->unsignedInteger('franquicia_id');
            $table->foreign('franquicia_id')->references('id')->on('franquicias_franquicia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mnt_clasificacion_documentos', function (Blueprint $table) {
            $table->dropForeign(['franquicia_id']);
            $table->dropColumn('franquicia_id');
        });
    }
};
