<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Crear el tipo ENUM en PostgreSQL

        $exists = DB::select("SELECT 1 FROM pg_type WHERE typname = 'estado_ruta'");

        if (!$exists) {
            DB::statement("CREATE TYPE estado_ruta AS ENUM ('pendiente', 'en_progreso', 'completado', 'anulado')");
        }

        Schema::table('rutas_lecturador', function (Blueprint $table) {
            $table->enum('estado', ['pendiente', 'en_progreso', 'completado', 'anulado'])
                ->default('pendiente');
        });
    }

    public function down(): void
    {
        Schema::table('rutas_lecturador', function (Blueprint $table) {
            $table->dropColumn('estado');
        });

        DB::statement('DROP TYPE estado_ruta');
    }
};
