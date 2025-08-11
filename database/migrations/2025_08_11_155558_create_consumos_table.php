<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('consumos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idInstalacion');
            $table->decimal('consumo', 10, 2);
            $table->string('foto')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('periodo');
            $table->timestamp('fecha_registro')->useCurrent();
            $table->timestamps();

            $table->foreign('idInstalacion')->references('id')->on('instalacions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('consumos');
    }
};
