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
    public function up()
    {
        DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_personal_id_foreign;');
        DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_personal_id_unique;');
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Volver a crear la FK antigua (ajusta el nombre y tabla si es necesario)
            $table->foreign('personal_id')->references('id')->on('personals')->onDelete('set null');
            $table->unique('personal_id');
        });
    }
};
