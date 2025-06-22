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
        Schema::create('niveles_cargo', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 255);
            $table->integer('jerarquia')->unsigned();
            $table->timestamps();
            $table->softDeletes(); // Opcional: para poder hacer soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('niveles_cargo');
    }
};
