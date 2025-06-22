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
    Schema::table('ruta_instalaciones', function (Blueprint $table) {
        // Agregar columna zona_id (antes era idZona para mantener consistencia)
        $table->unsignedBigInteger('idZona')->nullable()->after('idPredio');

        // Agregar la relación con zonas
        $table->foreign('idZona')->references('id')->on('zonas')->onDelete('cascade');

    });
}
    /**
     * Reverse the migrations.
     *
     * @return void
     */

public function down()
{
    Schema::table('ruta_instalaciones', function (Blueprint $table) {
        // Revertir la relación y columna zona_id
        $table->dropForeign(['idZona']);
        $table->dropColumn('idZona');

    });
}
};
