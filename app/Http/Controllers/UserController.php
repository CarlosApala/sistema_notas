<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

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
        $roles = Role::all();
        return view('sistema.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'username' => 'required|string|max:255|unique:users,username',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|exists:roles,name',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());
        }

        // No hace falta hashear aquí, el mutator del modelo lo hará

        $user = User::create($validated);

        $user->assignRole($validated['role']);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }

    public function show($id)
    {
        $user = User::find($id);

        return view('sistema.usuarios.show', compact('user'));
    }


    public function edit(User $usuario)
    {
        return view('sistema.usuarios.edit', compact('usuario'));
    }



    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'username' => 'required|string|max:255|unique:users,username,' . $usuario->id,
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $usuario->update($validated);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }


    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('sistema.usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }
}
