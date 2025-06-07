<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RutaInstalacionesController;

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

//Homepage route
Route::get('/', function () {
    return view('home.index');
})->middleware('auth');

// Login routes
// Route::get('/register',  [RegisterController::class, 'show']);

// Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/home',  [HomeController::class, 'index']);

Route::get('/logout',  [LogoutController::class, 'logout']);

// Auth
/* Route::get('/login', function () {
    return view('auth/login');
})->name('login');


 */

Route::middleware('auth')->group(function () {
    /* Route::resource('sistema/alumno', AlumnoController::class);
    Route::resource('sistema/profesor', ProfesorController::class);
    Route::resource('sistema/materias', MateriaController::class);
    Route::resource('sistema/carreras', CarreraController::class); */
    Route::get('sistema/rutas/{id}', function ($id) {
        $ruta = App\Models\Rutas::with('zona')->findOrFail($id);
        return response()->json($ruta);
    });
    Route::resource('sistema/usuarios',UserController::class);
    Route::resource('sistema/instalaciones', RutaInstalacionesController::class)->names('instalaciones');
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);

});

Route::middleware('role:admin')->group(function () {

    Route::resource('permissions', App\Http\Controllers\PermissionController::class);

});

Route::middleware('role:admin|maestro')->group(function () {


    Route::resource('permissions', App\Http\Controllers\PermissionController::class);

});
Route::middleware('role:admin|maestro|alumno')->group(function (){

});


Route::middleware('role:admin|alumno|maestro')->group(function () {

    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
});




//Password reset routes

Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
