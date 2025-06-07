<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rutas_lecturador', function (Blueprint $table) {
            $table->dropForeign(['idRuta']);

            // Crear la nueva clave foránea apuntando a ruta_instalaciones(id)
            $table->foreign('idRuta')->references('id')->on('ruta_instalaciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rutas_lecturador', function (Blueprint $table) {
            // Eliminar la nueva clave foránea
            $table->dropForeign(['idRuta']);

            // Restaurar la clave foránea original apuntando a rutas(id)
            $table->foreign('idRuta')->references('id')->on('rutas')->onDelete('cascade');
        });
    }
};
