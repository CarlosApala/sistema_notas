<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('instalacions', function (Blueprint $table) {
            $table->softDeletes();
        });
        //personals
        Schema::table('personals', function (Blueprint $table) {
            $table->softDeletes();
        });
        //predio
        Schema::table('predio', function (Blueprint $table) {
            $table->softDeletes();
        });
        //roles
        Schema::table('roles', function (Blueprint $table) {
            $table->softDeletes();
        });
        //permissions
        Schema::table('permissions', function (Blueprint $table) {
            $table->softDeletes();
        });
        //ruta_instalaciones
        Schema::table('ruta_instalaciones', function (Blueprint $table) {
            $table->softDeletes();
        });
        //rutas
        Schema::table('rutas', function (Blueprint $table) {
            $table->softDeletes();
        });
        //rutas_lecturador
        Schema::table('rutas_lecturador', function (Blueprint $table) {
            $table->softDeletes();
        });
        //users
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
        //zonas
        Schema::table('zonas', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instalacions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('personals', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        //predio
        Schema::table('predio', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        //roles
        Schema::table('roles', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        //permissions
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        //ruta_instalaciones
        Schema::table('ruta_instalaciones', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        //rutas
        Schema::table('rutas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        //rutas_lecturador
        Schema::table('rutas_lecturador', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        //users
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        //zonas
        Schema::table('zonas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
