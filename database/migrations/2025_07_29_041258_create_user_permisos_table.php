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
        Schema::create('user_permisos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->unsignedBigInteger('permissions_id');
            $table->foreign('permissions_id')
                ->references('id')->on('permissions')
                ->onDelete('cascade');

            $table->timestamps(); // crea created_at y updated_at con timestamps automáticos
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_permisos');
    }
};
