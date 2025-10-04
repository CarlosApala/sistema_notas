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
        Schema::create('socios', function (Blueprint $table) {
            $table->id();

            $table->string('nombres');
            $table->string('apellidos');
            $table->string('nro_ci')->unique();
            $table->string('direccion')->nullable();
            $table->enum('sexo', ['M', 'F'])->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('profesion')->nullable();
            $table->string('nit')->nullable();
            $table->string('numero_celular')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('actividad')->nullable();
            $table->text('observaciones')->nullable();
            $table->date('fecha_registro')->default(now());
            $table->boolean('status')->default(1); // 1=activo, 0=inactivo

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socios');
    }
};
