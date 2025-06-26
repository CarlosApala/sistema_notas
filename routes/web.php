<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InstalacionController;
use App\Http\Controllers\OrganigramaController;
use App\Http\Controllers\PersonalInternoController;
use App\Http\Controllers\PredioController;
use App\Http\Controllers\RutasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RutasLecturadorController;
use App\Http\Controllers\UsuariosLecturadores;
use App\Http\Controllers\UsuariosLecturadoresController;
use App\Http\Controllers\ZonasController;
use App\Http\Controllers\ZonasRutaController;
use App\Models\PersonalInterno;
use App\Models\RutaInstalaciones;
use App\Models\Rutas;
use App\Models\RutasLecturador;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

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
    Route::post('/usuarios/{id}/assign-role', [UserController::class, 'assignRole'])
        ->name('usuarios.assignRole');

    Route::resource('/sistema/lecturadores', RutasLecturadorController::class);
    Route::post('/sistema/lecturadores/{id}/restore', [RutasLecturadorController::class, 'restore'])
        ->name('lecturadores.restore');
    Route::resource('/sistema/zonas_rutas', ZonasRutaController::class);
    Route::put('/sistema/zonas_rutas/actualizar-ruta/{ruta}', [ZonasRutaController::class, 'actualizarRuta'])->name('zonas_rutas.actualizarRuta');
    Route::delete('/sistema/zonas_rutas/delete-ruta/{ruta}', [ZonasRutaController::class, 'eliminarRuta'])->name('zonas_rutas.eliminarRuta');

    Route::resource('/sistema/rutas', RutasController::class);
    Route::resource('/sistema/zonas', ZonasController::class);

    Route::resource('/sistema/instalaciones', InstalacionController::class);
    Route::post('/sistema/instalaciones/{id}/restore', [InstalacionController::class, 'restore'])->name('instalaciones.restore');

    Route::resource('/sistema/predios', PredioController::class);
    Route::post('/sistema/predios/{id}/restore', [PredioController::class, 'restore'])->name('predios.restore');

    Route::resource('/sistema/organigrama', OrganigramaController::class);

    Route::resource('/sistema/usuarios_lecturadores', UsuariosLecturadoresController::class);
    Route::post('/sistema/usuarios_lecturadores/{id}/assign-lecturador', [UsuariosLecturadoresController::class, 'assignLecturador']);


    Route::resource('/sistema/personal_interno', PersonalInternoController::class);
    Route::post('/sistema/personal_interno/{id}/restore', [PersonalInternoController::class, 'restore'])->name('personal_interno.restore');



    // Ruta adicional para restaurar predios eliminados (soft delete)
    Route::post('/sistema/predios/{id}/restore', [PredioController::class, 'restore'])->name('predios.restore');

    //rutas para carga asincrona
    Route::get('/api/rutas', function (Request $request) {
        $perPage = $request->input('per_page', 10); // número de registros por página, 10 por defecto
        $rutas = Rutas::with('zona')->paginate($perPage);
        return response()->json($rutas);
    })->name('api.rutas');

    Route::get('/api/predios', function () {
        $predios = \App\Models\Predio::select('id', 'direccion', 'zonaBarrio', 'distrito')->paginate(10);
        return response()->json($predios);
    });


    Route::get('/api/getRoles', function () {
        return response()->json(\Spatie\Permission\Models\Role::pluck('name'));
    });

    Route::get('/api/usuarios', function () {
        return response()->json(User::limit(50)->get());
    })->name('api.usuarios');

    Route::get('/api/lecturadores', function () {
        $lecturadores = User::role('lecturador')->get(); // Spatie: busca usuarios con ese rol
        return response()->json($lecturadores);
    });
});
