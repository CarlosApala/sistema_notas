<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\InstalacionController;
use App\Http\Controllers\ModulosController;
use App\Http\Controllers\OrganigramaController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PersonalInternoController;
use App\Http\Controllers\PredioController;
use App\Http\Controllers\RutasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RutasLecturadorController;
use App\Http\Controllers\UsuariosLecturadores;
use App\Http\Controllers\UsuariosLecturadoresController;
use App\Http\Controllers\ZonasController;
use App\Http\Controllers\ZonasRutaController;
use App\Models\Configuracion;
use App\Models\Instalacion;
use App\Models\Modulo;
use App\Models\Permission;
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

// Versión con prefijo para TODAS las rutas (incluyendo las públicas)
Route::prefix('nLecturaMovil')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('nLecturaMovil.login'), // Ajusta el nombre de la ruta
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    });
});

Route::prefix('nLecturaMovil')->group(function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    // Ruta para procesar el login (POST)
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // Ruta para logout (POST)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('nLecturaMovil')
    ->group(function () {



        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');



        Route::get('/sistema/usuarios/editar', [UserController::class, 'indexEdit'])
            ->name('usuarios.editarIndex');
        Route::get('/sistema/usuarios/delete', [UserController::class, 'indexDelete'])
            ->name('usuarios.editarDelete');
        Route::resource('/sistema/usuarios', UserController::class);
        Route::post('/usuarios/{id}/assign-role', [UserController::class, 'assignRole'])
            ->name('usuarios.assignRole');

        Route::resource('/sistema/lecturadores', RutasLecturadorController::class);
        Route::post('/sistema/lecturadores/{id}/restore', [RutasLecturadorController::class, 'restore'])
            ->name('lecturadores.restore');
        Route::resource('/sistema/zonas_rutas', ZonasRutaController::class);
        Route::put('/sistema/zonas_rutas/actualizar-ruta/{ruta}', [ZonasRutaController::class, 'actualizarRuta'])->name('zonas_rutas.actualizarRuta');
        Route::delete('/sistema/zonas_rutas/delete-ruta/{ruta}', [ZonasRutaController::class, 'eliminarRuta'])->name('zonas_rutas.eliminarRuta');


        Route::get('/sistema/rutas/editar-rutas', [RutasController::class, 'indexEdit'])->name('rutas.editar');
        Route::get('/sistema/rutas/eliminar-rutas', [RutasController::class, 'indexDelete'])->name('rutas.eliminar');
        Route::resource('/sistema/rutas', RutasController::class);
        Route::resource('/sistema/zonas', ZonasController::class);

        Route::get('/sistema/instalaciones/eliminar', [InstalacionController::class, 'indexDelete'])->name('instalaciones.delete');
        Route::get('/sistema/instalaciones/editar', [InstalacionController::class, 'indexEdit'])->name('instalaciones.edit.otra');
        Route::resource('/sistema/instalaciones', InstalacionController::class);
        Route::post('/sistema/instalaciones/{id}/restore', [InstalacionController::class, 'restore'])->name('instalaciones.restore');

        Route::get('/sistema/predios/eliminar', [PredioController::class, 'indexDelete'])->name('predios.indexDelete');
        Route::get('/sistema/predios/editar', [PredioController::class, 'indexEdit'])->name('predios.indexEditar');
        Route::resource('/sistema/predios', PredioController::class);
        Route::post('/sistema/predios/{id}/restore', [PredioController::class, 'restore'])->name('predios.restore');

        Route::resource('/sistema/organigrama', OrganigramaController::class);

        Route::get('/sistema/usuarios_lecturadores/editar', [UsuariosLecturadoresController::class, 'indexEdit'])
            ->name('usuarios_lecturadores.editarIndex');
        Route::get('/sistema/usuarios_lecturadores/eliminar', [UsuariosLecturadoresController::class, 'indexDelete'])
            ->name('usuarios_lecturadores.eliminarIndex');
        Route::resource('/sistema/usuarios_lecturadores', UsuariosLecturadoresController::class);
        Route::post('/sistema/usuarios_lecturadores/{id}/assign-lecturador', [UsuariosLecturadoresController::class, 'assignLecturador']);

        Route::get('/sistema/personal_interno/editar', [PersonalInternoController::class, 'indexEdit'])
            ->name('personal_interno.editarIndex');
        Route::get('/sistema/personal_interno/eliminar', [PersonalInternoController::class, 'indexDelete'])
            ->name('personal_interno.eliminarIndex');
        Route::resource('/sistema/personal_interno', PersonalInternoController::class);
        Route::post('/sistema/personal_interno/{id}/restore', [PersonalInternoController::class, 'restore'])->name('personal_interno.restore');

        Route::get('/zonas-editar', [ZonasController::class, 'indexEdit']);
        Route::get('/zonas-eliminar', [ZonasController::class, 'indexDelete']);
        //Route::get('/sistema/zonas/editar', [ZonasController::class, 'indexEdit']);
        Route::resource('/sistema/zonas', ZonasController::class);



        Route::resource('permisos', PermissionController::class)->except(['index']);



        /* Route::resource('/sistema/Modulos', ConfiguracionController::class);
    Route::post('/sistema/Modulos/{id}/restore', [ConfiguracionController::class, 'restore'])->name('configuracion.restore'); */

        Route::get('/sistema/modulos/{id}/asignarPrograma', [ModulosController::class, 'asignar'])
            ->name('modulos.asignar');
        Route::get('/sistema/modulos/eliminar', [ModulosController::class, 'eliminar'])->name('modulos.eliminar');
        Route::get('/sistema/modulos/modificar', [ModulosController::class, 'modificar'])->name('modulos.modificar');
        Route::resource('/sistema/modulos', ModulosController::class);


        // Ruta adicional para restaurar predios eliminados (soft delete)
        Route::post('/sistema/predios/{id}/restore', [PredioController::class, 'restore'])->name('predios.restore');

        //rutas para carga asincrona


        Route::get('/api/permissions', function (Request $request) {
            $perPage = $request->input('per_page', 10);
            $search = $request->input('search');
            $moduloId = $request->input('modulo_id');

            Log::info('modulo_id recibido: ' . $moduloId);

            $query = Permission::select('id', 'name', 'nombre', 'modulo_id');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('nombre', 'LIKE', "%{$search}%");
                });
            }

            if ($moduloId) {
                $query->where('modulo_id', $moduloId);
            }

            return $query->orderBy('id')->paginate($perPage);
        })->name('api.permissions');


        Route::get('/api/permissions/by-modulo', function (Request $request) {
            $perPage = $request->input('per_page', 10);
            $search = $request->input('search');
            $moduloId = $request->input('modulo_id');

            if (!$moduloId) {
                return response()->json(['error' => 'modulo_id es requerido'], 400);
            }

            $query = Permission::select('id', 'name', 'nombre', 'modulo_id')
                ->where('modulo_id', $moduloId);

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('nombre', 'LIKE', "%{$search}%");
                });
            }

            return $query->orderBy('id')->paginate($perPage);
        })->name('api.permissions.by-modulo');




        Route::get('/api/permissions/no-modulo', function (Request $request) {
            $perPage = $request->input('per_page', 10);
            $search = $request->input('search');

            $query = Permission::select('id', 'name', 'nombre', 'modulo_id')
                ->whereNull('modulo_id');  // Solo permisos sin módulo asignado

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('nombre', 'LIKE', "%{$search}%");
                });
            }

            return $query->paginate($perPage);
        })->name('api.permissions.noModulo');


        Route::get('/api/rutas', function (Request $request) {
            $perPage = $request->input('per_page', 10);
            $search = $request->input('search');
            $query = Rutas::with('zona');
            if ($search) {
                $query->where('NombreRuta', 'LIKE', "%{$search}%");
            }
            return $query->paginate($perPage);
        })->name('api.rutas');

        Route::get('/api/modulos', function (Request $request) {
            $perPage = $request->input('per_page', 10);
            $search = $request->input('search');
            $query = Modulo::query();

            if ($search) {
                $query->where('nombre', 'LIKE', "%{$search}%");
            }

            return $query->orderBy('id', 'asc')->paginate($perPage);
        })->name('api.modulos');


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
                $query->where(function ($q) use ($search) {
                    $q->where('NombreZona', 'like', "%{$search}%");
                });
            }

            $query->orderBy('id', 'asc');

            $perPage = $request->query('per_page', 10);
            $zonas = $query->paginate($perPage)->appends($request->query());

            // Opcional: Si quieres ocultar timestamps o columnas que no necesitas,
            // puedes usar ->makeHidden(['created_at', 'updated_at'])

            return response()->json($zonas);
        });

        Route::get('/api/zonas/rutas/{zona}', function ($zonaId) {
            $rutas = Rutas::where('zona_id', $zonaId)->get();

            return response()->json([
                'rutas' => $rutas,
            ]);
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
