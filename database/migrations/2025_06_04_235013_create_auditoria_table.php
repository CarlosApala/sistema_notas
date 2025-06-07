<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('auditoria', function (Blueprint $table) {
            $table->id(); // PRIMARY KEY with auto-increment
            $table->string('tabla_afectada', 100);
            $table->integer('id_registro');
            $table->string('tipo_operacion', 20); // INSERT, UPDATE, DELETE
            $table->text('datos_anteriores')->nullable(); // equivalente a NVARCHAR(MAX)
            $table->text('datos_nuevos')->nullable();
            $table->string('usuario', 100);
            $table->timestamp('fecha_hora')->default(DB::raw('CURRENT_TIMESTAMP')); // PostgreSQL
            $table->string('ip_origen', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auditoria');
    }
};
