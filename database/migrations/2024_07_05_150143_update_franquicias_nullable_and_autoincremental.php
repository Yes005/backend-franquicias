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
        Schema::table('franquicias_franquicia', function(Blueprint $table){
            $table->longText('comentario_anulacion')->nullable()->change();
            $table->longText('comentario_correccion')->nullable()->change();
            $table->string('no_orden',250)->nullable()->change();

            $table->unsignedInteger('id')->autoIncrement()->change();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('franquicias_franquicia', function(Blueprint $table){
            $table->longText('comentario_anulacion')->nullable(false)->change();
            $table->longText('comentario_correccion')->nullable(false)->change();
            $table->string('no_orden',250)->nullable(false)->change();

            $table->dropColumn('id');
            $table->bigInteger('id')->unsigned()->change();

        });
    }
};
