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
use App\Models\Instalacion;
use App\Models\PersonalInterno;
use App\Models\Predio;
use App\Models\RutaInstalaciones;
use App\Models\Rutas;
use App\Models\RutasLecturador;
use App\Models\User;
use App\Models\Zonas;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        $query = Rutas::with('zona');
        if ($search) {
            $query->where('NombreRuta', 'LIKE', "%{$search}%");
        }
        return $query->paginate($perPage);
    })->name('api.rutas');

    Route::get('/api/predios', function (Request $request) {
        $search = $request->query('search');
        $perPage = $request->input('per_page', 10);
        $deleted = $request->query('deleted');  // <-- Capturamos el filtro deleted

        $query = Predio::select('id', 'direccion', 'zonaBarrio', 'distrito');

        // Si el filtro deleted es true, solo obtenemos los registros eliminados
        if ($deleted === 'true') {
            $query->onlyTrashed();
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('direccion', 'like', "%{$search}%")
                    ->orWhere('zonaBarrio', 'like', "%{$search}%")
                    ->orWhere('distrito', 'like', "%{$search}%");
            });
        }

        return response()->json($query->paginate($perPage));
    });

    Route::get('/api/getRoles', function () {
        return response()->json(\Spatie\Permission\Models\Role::pluck('name'));
    });

    Route::get('/api/personal_interno', function (Request $request) {
        $search = $request->query('search');
        $query = PersonalInterno::query();
        if ($search) {
            $query->where('nombres', 'like', "%{$search}%")
                ->orWhere('apellidos', 'like', "%{$search}%")
                ->orWhere('carnet_identidad', 'like', "%{$search}%")
                ->orWhere('numero_celular', 'like', "%{$search}%");
        }

        return response()->json($query->paginate($request->input('per_page', 10)));
    });

    Route::get('/api/instalaciones', function (Request $request) {
        try {
            $search = $request->input('search');
            $onlyDeleted = $request->boolean('deleted'); // true si ?deleted=true
            $perPage = $request->input('per_page', 10);

            $query = Instalacion::with(['predio:id,direccion']); // Carga relación con predio limitando campos

            if ($onlyDeleted) {
                // Solo registros eliminados (soft deletes)
                $query->onlyTrashed();
            } else {
                // Solo registros activos (no eliminados)
                $query->whereNull('deleted_at');
            }

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('NumeroMedidor', 'ilike', "%{$search}%")
                        ->orWhere('EstadoInstalacion', 'ilike', "%{$search}%")
                        ->orWhere('EstadoAlcantarillado', 'ilike', "%{$search}%")
                        ->orWhere('EstadoCorte', 'ilike', "%{$search}%")
                        ->orWhereHas('predio', function ($q2) use ($search) {
                            $q2->where('direccion', 'ilike', "%{$search}%")
                                ->orWhere('zonaBarrio', 'ilike', "%{$search}%")
                                ->orWhere('distrito', 'ilike', "%{$search}%");
                        });
                });
            }

            return response()->json(
                $query->orderBy('id', 'asc')
                    ->paginate($perPage)
                    ->appends($request->query())
            );
        } catch (\Exception $e) {
            Log::error('Error en API instalaciones: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener instalaciones'], 500);
        }
    });

    Route::get('/api/zonas_rutas', function (Request $request) {
        $search = $request->query('search');
        $onlyDeleted = filter_var($request->query('deleted'), FILTER_VALIDATE_BOOLEAN);

        $query = Zonas::query();

        if ($onlyDeleted) {
            $query->onlyTrashed();
        }

        if ($search) {
            $query->where('NombreZona', 'ilike', "%{$search}%");
        }

        $query->with(['rutas' => function ($q) {
            $q->select('id', 'NombreRuta', 'zona_id')
                ->whereNull('deleted_at');
        }]);

        $perPage = $request->query('per_page', 10);

        $zonas = $query->select('id', 'NombreZona')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->appends($request->query());

        return response()->json($zonas);
    });
    Route::get('/api/zonas', function (Request $request) {
        $search = $request->query('search');
        $query = Zonas::query();
        if ($search) {
            $query->where('NombreZona', 'like', "%{$search}%")
                ->orWhere('Distrito', 'like', "%{$search}%");
        }
        return response()->json($query->paginate($request->input('per_page', 10)));
    });

    Route::get('/api/usuarios', function (Request $request) {
        $query = User::query();
        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }
        $perPage = $request->query('per_page', 10);
        $users = $query->paginate($perPage)->appends($request->query());
        return response()->json($users);
    })->name('api.usuarios');

    Route::get('/api/lecturadores', function (Request $request) {
        $query = User::role('lecturador');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }
        return response()->json($query->paginate($request->get('per_page', 10)));
    });
});
