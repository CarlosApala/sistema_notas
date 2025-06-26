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
        Schema::table('ruta_instalaciones', function (Blueprint $table) {
            $table->dropForeign(['idZona']);
        });
    }

    public function down(): void
    {
        Schema::table('ruta_instalaciones', function (Blueprint $table) {
            $table->foreign('idZona')->references('id')->on('zonas')->onDelete('cascade');
        });
    }
};
