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
        Schema::dropIfExists('zonas_rutas');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('zonas_rutas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('idZona');
            $table->unsignedBigInteger('idRuta');

            $table->foreign('idZona')->references('id')->on('zonas')->onDelete('cascade');
            $table->foreign('idRuta')->references('id')->on('rutas')->onDelete('cascade');

            $table->timestamps();
        });
    }
};
