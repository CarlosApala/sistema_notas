<?php

namespace App\Http\Controllers;

use App\Models\PersonalInterno;
use App\Models\RutasLecturador;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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

        return Inertia::render('sistema/Usuarios/Index', [
            'users' => $users,
            'flash' => ['success' => session('success')],
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $roles = Role::all(['id', 'name']);

        $personasSinUsuario = PersonalInterno::whereDoesntHave('user')->orderBy('id', 'asc')->paginate(10);

        return Inertia::render('sistema/Usuarios/Create', [
            'personas' => $personasSinUsuario,
            'roles' => $roles
        ]);
    }


    /*     public function create()
    {
        $roles = Role::all(['id', 'name']);
        $personas = PersonalInterno::orderBy('id', 'asc')->paginate(10);

        return Inertia::render('sistema/Usuarios/Create', [
            'personas' => $personas,
            'roles' => $roles
        ]);
    } */

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'carnet_identidad' => 'required|string|max:50|exists:personal_interno,carnet_identidad',
            'numero_celular' => 'nullable|string|max:20',
            'rol' => 'nullable|string|exists:roles,name',
        ]);

        try {
            DB::beginTransaction();

            $personal = PersonalInterno::where('carnet_identidad', $validated['carnet_identidad'])->firstOrFail();

            $fullName = $validated['nombres'] . ' ' . $validated['apellidos'];

            // Username único con base en los 3 primeros caracteres
            $usernameBase = substr($validated['carnet_identidad'], 0, 3);
            $username = $usernameBase;
            $counter = 1;

            while (User::where('username', $username)->exists()) {
                $username = $usernameBase . $counter;
                $counter++;
            }

            $email = $username . '@example.com';
            $password = bcrypt('password');

            // Crear el usuario primero (sin asignar personal_id aún)
            $user = User::create([
                'name' => $fullName,
                'email' => $email,
                'username' => $username,
                'password' => $password,
            ]);

            // Actualizar el personal con posibles cambios en datos (opcional)
            $personal->update([
                'nombres' => $validated['nombres'],
                'apellidos' => $validated['apellidos'],
                'numero_celular' => $validated['numero_celular'],
            ]);

            // Actualizar el usuario con la relación a personal
            $user->update(['personal_id' => $personal->id]);

            // Asignar rol si viene
            if (!empty($validated['rol'])) {
                $user->assignRole($validated['rol']);
            }

            DB::commit();

            return redirect()->route('usuarios.index')->with('success', 'Usuario y personal registrados correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creando usuario/personal: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Ocurrió un error al registrar. Intenta nuevamente.']);
        }
    }






    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::with('roles.permissions')->findOrFail($id);


        $permisosUsuario = $user->getAllPermissions()->pluck('name')->toArray();

        $permisosPorRol = [];
        foreach ($user->roles as $rol) {
            $permisosPorRol[$rol->name] = $rol->permissions->pluck('name')->toArray();
        }

        return Inertia::render('sistema/Usuarios/Show', [
            'user' => $user,
            'permisosUsuario' => $permisosUsuario,
            'permisosPorRol' => $permisosPorRol,
        ]);
    }

    public function edit(User $usuario)
    {
        $rolesDisponibles = Role::all();
        $permisosDisponibles = Permission::all();
        $rolesUsuario = $usuario->roles->pluck('name')->toArray();
        $permisosUsuarioDirectos = $usuario->getDirectPermissions()->pluck('name')->toArray();

        return Inertia::render('sistema/Usuarios/Edit', [
            'usuario' => $usuario,
            'rolesDisponibles' => $rolesDisponibles,
            'permisosDisponibles' => $permisosDisponibles,
            'rolesUsuario' => $rolesUsuario,
            'permisosUsuarioDirectos' => $permisosUsuarioDirectos,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'idRuta' => 'required|exists:ruta_instalaciones,id',
            'idUser' => 'required|exists:users,id',
            'periodo' => 'nullable|string|max:191',
        ]);

        $rutasLecturador = RutasLecturador::findOrFail($id);

        $rutasLecturador->idRuta = $request->idRuta;
        $rutasLecturador->idUser = $request->idUser;
        $rutasLecturador->periodo = $request->periodo;

        $rutasLecturador->save();

        // Redirigir usando Inertia a la lista con mensaje de éxito
        return redirect()->route('lecturadores.index')
            ->with('success', 'Asignación actualizada exitosamente.');
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
