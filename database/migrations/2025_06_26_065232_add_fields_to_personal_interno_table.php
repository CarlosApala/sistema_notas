<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personal_interno', function (Blueprint $table) {
            $table->string('direccion')->nullable()->after('apellido'); // Ajusta "apellido" al último campo que tengas
            $table->enum('genero', ['Masculino', 'Femenino', 'Otro'])->nullable()->after('direccion');
            $table->string('lugar_nacimiento')->nullable()->after('genero');
            $table->string('email')->nullable()->unique()->after('lugar_nacimiento');
        });
    }

    public function down(): void
    {
        Schema::table('personal_interno', function (Blueprint $table) {
            $table->dropColumn(['direccion', 'genero', 'lugar_nacimiento', 'email']);
        });
    }
};
