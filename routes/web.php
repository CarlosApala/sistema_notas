<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InstalacionController;
use App\Http\Controllers\OrganigramaController;
use App\Http\Controllers\PersonalInternoController;
use App\Http\Controllers\PredioController;
use App\Http\Controllers\RutasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RutasLecturadorController;
use App\Http\Controllers\ZonasController;
use App\Http\Controllers\ZonasRutaController;
use App\Models\PersonalInterno;
use App\Models\RutaInstalaciones;
use App\Models\RutasLecturador;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('/sistema/usuarios', UserController::class);
    Route::resource('/sistema/lecturadores', RutasLecturadorController::class);
    Route::post('/sistema/lecturadores/{id}/restore', [RutasLecturadorController::class, 'restore'])
        ->name('lecturadores.restore');
    Route::resource('/sistema/zonas_rutas', ZonasRutaController::class);
    Route::resource('/sistema/rutas', RutasController::class);
    Route::resource('/sistema/zonas', ZonasController::class);

    Route::resource('/sistema/instalaciones', InstalacionController::class);
    Route::post('/sistema/instalaciones/{id}/restore', [InstalacionController::class, 'restore'])->name('instalaciones.restore');

    Route::resource('/sistema/predios', PredioController::class);
    Route::post('/sistema/predios/{id}/restore', [PredioController::class, 'restore'])->name('predios.restore');

    Route::resource('/sistema/organigrama',OrganigramaController::class);

    Route::resource('/sistema/personal_interno',PersonalInternoController::class);
    Route::post('/sistema/personal_interno/{id}/restore',[PersonalInternoController::class,'restore'])->name('personal_interno.restore');
    // Ruta adicional para restaurar predios eliminados (soft delete)
    Route::post('/sistema/predios/{id}/restore', [PredioController::class, 'restore'])->name('predios.restore');




    //rutas para carga asincrona
    Route::get('/api/rutas', function () {
        return response()->json(RutaInstalaciones::with('ruta')->limit(50)->get());
    })->name('api.rutas');
    Route::get('/api/predios', [PredioController::class, 'listJson']);


    Route::get('/api/usuarios', function () {
        return response()->json(User::limit(50)->get());
    })->name('api.usuarios');
});
