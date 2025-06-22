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
        Schema::create('predio', function (Blueprint $table) {
            $table->id();

            $table->string('direccion')->nullable();
            $table->string('ubicaciongps')->nullable();
            $table->string('zonaBarrio')->nullable();
            $table->string('distrito')->nullable();
            $table->string('UnidadVecinal')->nullable();
            $table->string('Manzana')->nullable();
            $table->decimal('AreaPredio', 10, 2)->nullable();
            $table->decimal('LongitudFrente', 10, 2)->nullable();
            $table->decimal('AreaConstruida', 10, 2)->nullable();
            $table->integer('NroHaitaciones')->nullable(); // ¿Es "NroHabitaciones"? Corrige si es typo
            $table->integer('NroPisos')->nullable();
            $table->integer('NroGrifos')->nullable();
            $table->integer('NroBaños')->nullable();
            $table->string('TipoEdificacion')->nullable();
            $table->boolean('Pavimento')->default(false);
            $table->string('EstadoEdificacion')->nullable();
            $table->boolean('PredioHabitado')->default(false);
            $table->text('Observaciones')->nullable();

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
        Schema::dropIfExists('predios');
    }
};
