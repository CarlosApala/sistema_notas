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
        Schema::table('rutas_lecturador', function (Blueprint $table) {
            // Agregar clave foránea a la tabla rutas
            $table->foreign('idRuta')
                  ->references('id')
                  ->on('rutas')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('rutas_lecturador', function (Blueprint $table) {
            // Eliminar la clave foránea si se hace rollback
            $table->dropForeign(['idRuta']);
        });
    }
};
