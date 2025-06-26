<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rutas_lecturador', function (Blueprint $table) {
            // Eliminar la clave foránea incorrecta
            $table->dropForeign(['idRuta']);
        });
    }

    public function down(): void
    {
        Schema::table('rutas_lecturador', function (Blueprint $table) {
            // Restaurar la relación original si fuera necesario
            $table->foreign('idRuta')
                ->references('id')
                ->on('ruta_instalaciones')
                ->onDelete('cascade');
        });
    }
};
