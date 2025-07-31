<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\PersonalInterno;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Usuarios que tienen un personal interno asignado
        $users = User::whereNotNull('personal_id')->with('personal')->get();

        // Si necesitas mostrar algo adicional por usuario (no obligatorio aquí)
        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ];
        });

        // Obtener permisos del usuario autenticado desde tabla personalizada
        $usuarioActual = Auth::user();
        $permisos = $usuarioActual?->permissions->pluck('name') ?? [];



        return Inertia::render('sistema/Usuarios/Index', [
            'users' => $data,
            'permissions' => $permisos,
            'flash' => ['success' => session('success')],
        ]);
    }

    public function indexDelete()
    {
        // Usuarios que tienen un personal interno asignado
        $users = User::whereNotNull('personal_id')->with('personal')->get();

        // Si necesitas mostrar algo adicional por usuario (no obligatorio aquí)
        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ];
        });

        // Obtener permisos del usuario autenticado desde tabla personalizada
        $usuarioActual = Auth::user();
        $permisos = $usuarioActual?->permissions->pluck('name') ?? [];



        return Inertia::render('sistema/Usuarios/IndexDelete', [
            'users' => $data,
            'permissions' => $permisos,
            'flash' => ['success' => session('success')],
        ]);
    }

    public function indexEdit()
    {
        // Usuarios que tienen un personal interno asignado
        $users = User::whereNotNull('personal_id')->with('personal')->get();

        // Si necesitas mostrar algo adicional por usuario (no obligatorio aquí)
        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ];
        });

        // Obtener permisos del usuario autenticado desde tabla personalizada
        $usuarioActual = Auth::user();
        $permisos = $usuarioActual?->permissions->pluck('name') ?? [];

        return Inertia::render('sistema/Usuarios/IndexEdit', [
            'users' => $data,
            'permissions' => $permisos,
            'flash' => ['success' => session('success')],
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        // Traer todos los permisos con su módulo asociado
        $permisosConModulos = Permission::select('permissions.name', 'modulos.nombre as modulo_nombre', 'permissions.programa')
            ->join('modulos', 'permissions.modulo_id', '=', 'modulos.id')
            ->get();

        // Estructura deseada: [modulo => [programa => [ ['accion' => '', 'name' => ''] ] ] ]
        $estructura = [];

        foreach ($permisosConModulos as $permiso) {
            $modulo = $permiso->modulo_nombre;
            $programa = $permiso->programa;

            $partes = explode('.', $permiso->name);
            $accion = $partes[1] ?? null;

            if (!$accion) {
                continue;
            }

            if (!isset($estructura[$modulo])) {
                $estructura[$modulo] = [];
            }

            if (!isset($estructura[$modulo][$programa])) {
                $estructura[$modulo][$programa] = [];
            }

            $estructura[$modulo][$programa][] = [
                'accion' => $accion,
                'name' => $permiso->name,
            ];
        }

        return Inertia::render('sistema/Usuarios/Create', [
            'estructuraModulos' => $estructura,
            'permisosUsuario' => [], // Inicialmente vacío
        ]);
    }





    public function store(Request $request)
    {
        try {
            // Validación: solo id de personal interno y permisos



            $validated = $request->validate([
                'personal_interno_id' => 'required|exists:personal_interno,id',
                'permisos' => 'present|array',
                'permisos.*' => 'string|exists:permissions,name',
            ]);


            DB::beginTransaction();

            // Buscar datos de personal_interno usando el id recibido
            $personal = PersonalInterno::findOrFail($validated['personal_interno_id']);

            // Armar nombre completo y username único basado en datos de personal
            $fullName = $personal->nombres . ' ' . $personal->apellidos;
            $usernameBase = $personal->nombres . substr($personal->carnet_identidad, 0, 3);
            $username = $usernameBase;
            $counter = 1;

            while (User::where('username', $username)->exists()) {
                $username = $usernameBase . $counter;
                $counter++;
            }



            $email = $username . '@example.com';
            //dd($fullName,$username,$email);
            // Crear usuario
            $user = User::create([
                'name' => $fullName,
                'email' => $email,
                'username' => $username,
                'password' => 'password', // Asegúrate de hashear la contraseña
                'personal_id' => $personal->id
            ]);

            $user->save();


            // Obtener IDs de permisos
            $permisosIds = Permission::whereIn('name', $validated['permisos'])->pluck('id')->toArray();


            // Limpiar permisos previos
            DB::table('user_permisos')->where('users_id', $user->id)->delete();

            // Insertar permisos nuevos
            foreach ($permisosIds as $permisoId) {
                DB::table('user_permisos')->insert([
                    'users_id' => $user->id,
                    'permissions_id' => $permisoId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }



            DB::commit();
            return redirect()
                ->route('usuarios.create')
                ->with('success', 'Usuario y personal registrados correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creando usuario/personal: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Ocurrió un error al registrar. Intenta nuevamente.']);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        // Obtener permisos asignados directamente al usuario
        $permisosUsuario = DB::table('user_permisos')
            ->join('permissions', 'permissions.id', '=', 'user_permisos.permissions_id')
            ->join('modulos', 'permissions.modulo_id', '=', 'modulos.id')
            ->where('user_permisos.users_id', $user->id)
            ->select('permissions.name', 'permissions.programa', 'modulos.nombre as modulo_nombre')
            ->get();

        // Construir estructura: "Gestión de Zonas" -> "zona" -> [acciones]
        $estructura = [];

        foreach ($permisosUsuario as $permiso) {
            $modulo = $permiso->modulo_nombre;
            $programa = $permiso->programa;
            $partes = explode('.', $permiso->name);
            $accion = $partes[1] ?? null;

            if (!$accion) continue;

            if (!isset($estructura[$modulo])) {
                $estructura[$modulo] = [];
            }

            if (!isset($estructura[$modulo][$programa])) {
                $estructura[$modulo][$programa] = [];
            }

            $yaExiste = collect($estructura[$modulo][$programa])
                ->contains('name', $permiso->name);

            if (!$yaExiste) {
                $estructura[$modulo][$programa][] = [
                    'accion' => $accion,
                    'name' => $permiso->name,
                ];
            }
        }

        return Inertia::render('sistema/Usuarios/Show', [
            'user' => $user,
            'estructuraModulos' => $estructura,
        ]);
    }




    public function edit($id)
    {
        // Obtener permisos asignados directamente al usuario


        $usuario = User::where('id', $id)->first();



        $permisosUsuario = DB::table('user_permisos')
            ->join('permissions', 'permissions.id', '=', 'user_permisos.permissions_id')
            ->join('modulos', 'permissions.modulo_id', '=', 'modulos.id')
            ->where('user_permisos.users_id', $usuario->id)
            ->select('permissions.name', 'permissions.programa', 'modulos.nombre as modulo_nombre')
            ->get();

        // Construir estructura: "Gestión de Zonas" -> "zona" -> [acciones]
        $estructura = [];

        foreach ($permisosUsuario as $permiso) {
            $modulo = $permiso->modulo_nombre;
            $programa = $permiso->programa;
            $partes = explode('.', $permiso->name);
            $accion = $partes[1] ?? null;

            if (!$accion) continue;

            if (!isset($estructura[$modulo])) {
                $estructura[$modulo] = [];
            }

            if (!isset($estructura[$modulo][$programa])) {
                $estructura[$modulo][$programa] = [];
            }

            $yaExiste = collect($estructura[$modulo][$programa])
                ->contains('name', $permiso->name);

            if (!$yaExiste) {
                $estructura[$modulo][$programa][] = [
                    'accion' => $accion,
                    'name' => $permiso->name,
                ];
            }
        }

        return Inertia::render('sistema/Usuarios/Edit', [
            'user' => $usuario,
            'estructuraModulos' => $estructura,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); // Busca el usuario por ID

        // Validación
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|confirmed|min:6',
            'permisos' => 'array',
            'permisos.*' => 'string'
        ]);

        // Actualiza los datos del usuario
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
        ]);

        if (!empty($validated['password'])) {
            $user->password = $request->password;
        }

        $user->save();

        // Manejo manual de la tabla user_permisos
        if (isset($validated['permisos'])) {
            // Elimina permisos anteriores
            DB::table('user_permisos')->where('users_id', $user->id)->delete();

            // Obtiene IDs de los permisos por sus nombres
            $permissionIds = DB::table('permissions')
                ->whereIn('name', $validated['permisos'])
                ->pluck('id')
                ->toArray();

            // Inserta los nuevos permisos
            $now = now();
            $insertData = array_map(fn($permissionId) => [
                'users_id' => $user->id,
                'permissions_id' => $permissionId,
                'created_at' => $now,
                'updated_at' => $now
            ], $permissionIds);

            DB::table('user_permisos')->insert($insertData);
        }
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::withTrashed()->findOrFail($id); // <-- ahora sí se encuentra
        $user->delete(); // este ya está eliminado, pero puedes hacer forceDelete() si deseas
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }

    public function assignRole(Request $request, $id)
    {


        $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::findOrFail($id);

        // Si quieres que solo tenga un rol, primero quitamos todos
        $user->syncRoles([$request->role]);

        // O si quieres permitir múltiples roles, usa esto:
        // $user->assignRole($request->role);

        return response()->json([
            'message' => 'Rol asignado correctamente',
        ]);
    }
}
