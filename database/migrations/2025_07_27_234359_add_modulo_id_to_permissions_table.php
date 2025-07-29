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
        Schema::table('permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('modulo_id')->nullable()->after('id');
            $table->foreign('modulo_id')->references('id')->on('modulos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['modulo_id']);
            $table->dropColumn('modulo_id');
        });
    }
};
