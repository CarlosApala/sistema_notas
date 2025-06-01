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
        Schema::create('instalacions', function (Blueprint $table) {
            $table->id();

            // Clave foránea hacia predios.id como idPredio
            $table->unsignedBigInteger('idPredio');
            $table->foreign('idPredio')->references('id')->on('predio')->onDelete('cascade');

            // Campos adicionales
            $table->date('FechaInstalacion')->nullable();
            $table->string('NumeroMedidor')->nullable();
            $table->string('EstadoInstalacion')->nullable();
            $table->string('EstadoAlcantarillado')->nullable();
            $table->text('Observaciones')->nullable();
            $table->integer('NroGrifos')->nullable();
            $table->integer('NroBaños')->nullable();
            $table->string('EstadoCorte')->nullable();
            $table->decimal('PromedioConsumo', 8, 2)->nullable();
            $table->string('CodigoUbicacion')->nullable();

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
        Schema::dropIfExists('instalacions');
    }
};
