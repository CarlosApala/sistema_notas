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
        Schema::create('configuraciones_empresa', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_empresa');
            $table->string('logo')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono_contacto')->nullable();
            $table->string('correo_contacto')->nullable();
            $table->string('sitio_web')->nullable();
            $table->text('descripcion')->nullable();
            $table->boolean('estado')->default(true);
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
        Schema::dropIfExists('configuraciones_empresa');
    }
};
