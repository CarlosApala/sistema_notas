<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('zonas_rutas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('zona_id');
            $table->unsignedBigInteger('ruta_id');

            $table->foreign('zona_id')->references('id')->on('zonas')->onDelete('cascade');
            $table->foreign('ruta_id')->references('id')->on('rutas')->onDelete('cascade');

            $table->unique(['zona_id', 'ruta_id']); // evitar duplicados
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zonas_rutas');
    }
};
