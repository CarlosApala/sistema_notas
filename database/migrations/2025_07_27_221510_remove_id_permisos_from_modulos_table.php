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
        Schema::table('modulos', function (Blueprint $table) {
            // Eliminar la clave foránea primero
            $table->dropForeign(['idPermisos']);

            // Luego eliminar la columna
            $table->dropColumn('idPermisos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('modulos', function (Blueprint $table) {
            // Restaurar la columna
            $table->unsignedBigInteger('idPermisos')->nullable();

            // Restaurar la clave foránea
            $table->foreign('idPermisos')->references('id')->on('permissions')->onDelete('cascade');
        });
    }
};
