<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthLecturadorController;
use App\Http\Controllers\Api\ConsumoController;
use App\Http\Controllers\Api\RutasLecturadorApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('lecturador')->group(function () {
    // Rutas que no requieren autenticación
    Route::post('/login', [AuthLecturadorController::class, 'login']);

    // Rutas que requieren autenticación con sanctum
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        // Aquí puedes agregar más rutas protegidas para lecturadores
        // Ejemplo:
        // Route::get('/perfil', [AuthLecturadorController::class, 'perfil']);
        // Route::post('/logout', [AuthLecturadorController::class, 'logout']);
        Route::get('/{userId}/rutas', [RutasLecturadorApiController::class, 'rutasAsignadas']);
        Route::post('/registrar-consumo', [ConsumoController::class, 'registrarConsumo']);
    });

});
