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
        Schema::create('personal_cargos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('personal_interno_id')
                ->constrained('personal_interno')
                ->onDelete('cascade');

            $table->foreignId('cargo_id')
                ->constrained('cargos')
                ->onDelete('cascade');

            $table->foreignId('dependencia_id')
                ->nullable()
                ->constrained('personal_cargos')
                ->onDelete('set null');

            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->boolean('activo')->default(true);

            $table->timestamps();
            $table->softDeletes();  // <-- Aquí agregas el soft delete
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_cargos', function (Blueprint $table) {
            $table->dropForeign(['personal_interno_id']);
            $table->dropForeign(['cargo_id']);
            $table->dropForeign(['dependencia_id']);
        });

        Schema::dropIfExists('personal_cargos');
    }
};
