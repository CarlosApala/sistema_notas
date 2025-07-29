<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PermissionController extends Controller
{
    public function store(Request $request)
    {
        dd($request);
        $request->validate([
            'permiso_id' => 'nullable|exists:permissions,id',
            'nombre_permiso' => 'required|string|max:255',
            'codigo_permiso' => 'required|string|max:255|unique:permissions,name',
        ]);
        dd($request);

        $permiso = new Permission();
        $permiso->nombre = $request->nombre_permiso;
        $permiso->name = $request->codigo_permiso;
        $permiso->modulo_id = $request->permiso_id; // puede ser null
        $permiso->guard_name = 'web'; // o el guard que uses
        $permiso->save();

        return redirect()->route('modulos.asignar', ['id' => $permiso->modulo_id])
        ->with('success', 'Permiso creado con éxito');
    }
    public function update(Request $request, Permission $permiso)
    {
        Log::info('Datos recibidos:', $request->all());

        $request->validate([
            'modulo_id' => 'nullable|exists:modulos,id',
        ]);

        $permiso->modulo_id = $request->modulo_id;
        $permiso->save();

        Log::info('Permiso después de update:', $permiso->toArray());
    }
}
