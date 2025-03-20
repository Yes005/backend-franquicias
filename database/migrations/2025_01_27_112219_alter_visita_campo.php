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
        Schema::table('mnt_visitas_campos', function (Blueprint $table) {
            $table->string('numero_seguimiento', 5)
                ->change();
            $table->date('fecha_visita')->nullable()->change();
            $table->longText('detalle')->nullable()->change();
            $table->unsignedBigInteger('categoria_visita_id')->nullable()->change();

            if (Schema::hasColumn('mnt_visitas_campos', 'codigo_franquicia')) {
                $table->dropColumn('codigo_franquicia');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mnt_visitas_campos', function (Blueprint $table) {
            $table->integer('numero_seguimiento')
                ->change();
            $table->date('fecha_visita')->nullable(false)->change();
            $table->longText('detalle')->nullable(false)->change();
            $table->unsignedBigInteger('categoria_visita_id')->nullable(false)->change();
        });
    }
};
