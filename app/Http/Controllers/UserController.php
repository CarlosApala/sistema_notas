<?php

namespace App\Http\Controllers;

use App\Models\RutasLecturador;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
        $users = User::all();
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
        return Inertia::render('sistema/Usuarios/Create', [
            'roles' => Role::all(),
            'permisos' => Permission::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

        // Validar los datos recibidos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|confirmed|min:6',
            'roles' => 'array',
            'roles.*' => 'string|exists:roles,name',
            'permisos' => 'array',
            'permisos.*' => 'string|exists:permissions,name',
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        // Asignar roles si vienen
        if (!empty($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        // Asignar permisos directos si vienen
        if (!empty($validated['permisos'])) {
            $user->syncPermissions($validated['permisos']);
        }

        // Redirigir con mensaje de éxito
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
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
}
