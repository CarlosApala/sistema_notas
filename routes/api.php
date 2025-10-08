<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthLecturadorController;
use App\Http\Controllers\Api\ConsumoController;
use App\Http\Controllers\Api\RutasLecturadorApiController;
use App\Http\Controllers\Api\AvisoController; // 👈 No olvides importar tu controlador
use App\Http\Controllers\Api\AsignacionController; // 👈 Import correcto

use App\Http\Controllers\Api\ObservacionController;


Route::prefix('lecturador')->group(function () {
    // Rutas que no requieren autenticación
    Route::post('/login', [AuthLecturadorController::class, 'login']);
    Route::get('/avisos', [AvisoController::class, 'index']); // 👈 Ruta libre, sin token
    Route::get('/asignaciones', [AsignacionController::class, 'index']);
    Route::get('/observaciones', [ObservacionController::class, 'index']);
    Route::get('/observaciones/{id}', [ObservacionController::class, 'show']);


    // Rutas que sí requieren autenticación con sanctum
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::get('/{userId}/rutas', [RutasLecturadorApiController::class, 'rutasAsignadas']);
        Route::post('/registrar-consumo', [ConsumoController::class, 'registrarConsumo']);
    });
});
