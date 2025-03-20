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
            $table->longText('nota')->nullable()->change();
            $table->longText('observacion')->nullable()->change();
            $table->date('fecha')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('franquicias_franquicia', function (Blueprint $table){
            $table->longText('nota')->nullable(false)->change();
            $table->longText('observacion')->nullable(false)->change();
            $table->date('fecha')->nullable(false)->change();

        });
    }
};
