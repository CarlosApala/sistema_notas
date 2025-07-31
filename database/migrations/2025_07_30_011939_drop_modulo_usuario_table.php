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
        Schema::dropIfExists('modulo_usuario');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('modulo_usuario', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('idUsuario');
            $table->foreign('idUsuario')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('idModulos');
            $table->foreign('idModulos')->references('id')->on('modulos')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
