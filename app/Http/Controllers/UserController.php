<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('sistema.usuarios.index', compact('users'));
    }

    public function create()
    {
        return view('sistema.usuarios.create', [
        'roles' => Role::all(),
        'permisos' => Permission::all(),
    ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'username' => 'required|string|max:255|unique:users,username',
                'password' => 'required|string|min:8|confirmed',
                'roles' => 'required|array',
                'roles.*' => 'exists:roles,name',
                'permisos' => 'nullable|array',
                'permisos.*' => 'exists:permissions,name',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());
        }

        // Crear el usuario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => $validated['password'], // Mutator se encarga del hash
        ]);

        // Asignar roles
        $user->syncRoles($validated['roles']);

        // Asignar permisos directos (si hay)
        if (!empty($validated['permisos'])) {
            $user->givePermissionTo($validated['permisos']);
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }


    public function show($id)
    {
        $user = User::findOrFail($id);

        $permisosUsuario = $user->getPermissionNames();

        $roles = $user->roles;

        $permisosPorRol = [];
        foreach ($roles as $rol) {
            $permisosPorRol[$rol->name] = $rol->permissions->pluck('name');
        }

        return view('sistema.usuarios.show', compact('user', 'permisosUsuario', 'permisosPorRol'));
    }


    public function edit(User $usuario)
    {
        // Obtener todos los roles para poder mostrarlos en un checkbox o select
        $rolesDisponibles = Role::all();

        // Obtener todos los permisos para mostrarlos y asignarlos
        $permisosDisponibles = Permission::all();

        // Obtener los roles que tiene el usuario
        $rolesUsuario = $usuario->roles->pluck('name')->toArray();

        // Obtener los permisos directos asignados al usuario (no vía roles)
        $permisosUsuarioDirectos = $usuario->getDirectPermissions()->pluck('name')->toArray();

        return view('sistema.usuarios.edit', compact(
            'usuario',
            'rolesDisponibles',
            'permisosDisponibles',
            'rolesUsuario',
            'permisosUsuarioDirectos'
        ));
    }


    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'username' => 'required|string|max:255|unique:users,username,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
            'permisos' => 'nullable|array',
            'permisos.*' => 'exists:permissions,name',
        ]);

        $usuario->name = $validated['name'];
        $usuario->email = $validated['email'];
        $usuario->username = $validated['username'];

        if (!empty($validated['password'])) {
            $usuario->password = $validated['password']; // Se encripta con mutator
        }

        $usuario->save();

        // Actualizar roles
        $usuario->syncRoles($validated['roles']);

        // Actualizar permisos directos
        $usuario->syncPermissions($validated['permisos'] ?? []);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }


    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('sistema.usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }
}
