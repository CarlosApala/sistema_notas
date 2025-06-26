<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar relación antigua si existiera
            $table->dropForeign(['personal_id']);
            $table->dropUnique(['personal_id']);

            // Crear relación one-to-one
            $table->unsignedBigInteger('personal_id')->nullable()->change();
            $table->unique('personal_id');
            $table->foreign('personal_id')->references('id')->on('personal_interno')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['personal_id']);
            $table->dropUnique(['personal_id']);
            // Aquí opcionalmente podrías revertir el tipo o dejar como nullable sin índice
        });
    }
};
