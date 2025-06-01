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
        Schema::create('ruta_instalaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idRuta');
            $table->foreign('idRuta')->references('id')->on('rutas')->onDelete('cascade');
            $table->unsignedBigInteger('idPredio');
            $table->foreign('idPredio')->references('id')->on('predio')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ruta_instalaciones');
    }
};
