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
        Schema::create('personal_interno', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->string('nombres');
            $table->string('apellidos');
            $table->date('fecha_nacimiento')->nullable();
            $table->string('carnet_identidad')->nullable()->unique();
            $table->string('nacionalidad')->nullable();
            $table->string('numero_celular')->nullable();
            $table->string('estado_civil')->nullable(); // Soltero, Casado, etc.

            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_interno');
    }
};
