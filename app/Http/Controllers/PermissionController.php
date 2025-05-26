<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        // Solo usuarios con el rol 'admin' pueden acceder a este controlador
        $this->middleware(['auth', 'role:admin']);
    }

    // Mostrar listado de permisos
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    // Mostrar formulario para crear permiso
    public function create()
    {
        return view('permissions.create');
    }

    // Guardar nuevo permiso
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permiso creado correctamente');
    }

    // Mostrar detalle del permiso (opcional)
    public function show(Permission $permission)
    {
        return view('permissions.show', compact('permission'));
    }

    // Mostrar formulario para editar permiso
    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    // Actualizar permiso
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permiso actualizado correctamente');
    }

    // Eliminar permiso
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('success', 'Permiso eliminado correctamente');
    }
}
