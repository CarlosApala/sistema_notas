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
        Schema::table('users', function (Blueprint $table) {
            // Añadir foreign key y unique para personal_id
            $table->foreign('personal_id')
                ->references('id')
                ->on('personal_interno')
                ->onDelete('set null');
            $table->unique('personal_id');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['personal_id']);
            $table->dropUnique(['personal_id']);
        });
    }
};
