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
        Schema::table('franquicias_franquicia', function (Blueprint $table){
            $table->renameColumn('codigo','codigo_provisional')->nullable()->default(null);
            $table->string('codigo_franquicia')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('franquicias_franquicia', function (Blueprint $table){
            $table->renameColumn('codigo_provisional','codigo');
            $table->dropColumn('codigo_franquicia');
        });
    }
};
