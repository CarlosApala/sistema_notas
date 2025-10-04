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
        Schema::table('predio', function (Blueprint $table) {
            $table->unsignedBigInteger('socio_id')->nullable()->after('id');

            $table->foreign('socio_id')
                  ->references('id')
                  ->on('socios')
                  ->onDelete('cascade'); // Si se borra un socio, se borran sus predios
        });
    }

    /**
     * Reverse the migrations.
     */
        public function down(): void
    {
        Schema::table('predio', function (Blueprint $table) {
            $table->dropForeign(['socio_id']);
            $table->dropColumn('socio_id');
        });
    }
};
