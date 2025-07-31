<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use App\Models\Permission;

class ModulosController extends Controller
{
    public function index(Request $request)
    {
        $query = Modulo::query();

        // Si viene búsqueda, filtramos por nombre (LIKE %search%)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nombre', 'LIKE', "%{$search}%");
        }


        // Paginar resultados, 10 por defecto
        $modulos = $query->orderBy('id', 'desc')->paginate($request->per_page ?? 10)->withQueryString();


        // Devolver paginación con Inertia en formato que Vue pueda manejar
        return Inertia::render('sistema/Modulos/Index', [
            'modulos' => [
                'data' => $modulos->items(),
                'links' => $modulos->links(),
                'total' => $modulos->total(),
                'per_page' => $modulos->perPage(),
                'current_page' => $modulos->currentPage(),
            ]
        ]);
    }




    function create()
    {
        return Inertia::render('sistema/Modulos/Create_Module');
    }

    public function asignar($id)
    {
        $modulo = Modulo::with('permissions')->findOrFail($id);
        $todosPermisos = Permission::where('modulo_id', $id)->get();

        // Genera la estructura para el componente
        $estructura = [
            $modulo->nombre => []
        ];

        foreach ($todosPermisos as $permiso) {
            $estructura[$modulo->nombre][$permiso->programa] = explode('.', $permiso->name)[0];
        }

        return Inertia::render('sistema/Modulos/AsignarPrograma', [
            'modulo' => $modulo,
            'estructuraModulos' => $estructura,
            'permisosUsuario' => $modulo->permissions->pluck('name')->unique()->values()
        ]);
    }



    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string|max:1000',
            ]);

            Modulo::create([
                'nombre' => $validated['nombre'],
                'descripcion' => $validated['descripcion'] ?? null,
            ]);

            // Usa redirect()->back() en lugar de return back()
            return Inertia::render('sistema/Modulos/Create_Module', [
                'flash' => ['success' => 'Módulo creado correctamente.'],
            ]);
        } catch (\Exception $e) {
            Log::error('Error al guardar módulo: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Hubo un problema al guardar el módulo.']);
        }
    }


    function modificar()
    {
        return Inertia::render('sistema/Modulos/Update');
    }
    function eliminar()
    {
        return Inertia::render('sistema/Modulos/Delete');
    }
    function show(Modulo $modulo)
    {
        return Inertia::render('sistema/Modulos/Show');
    }
}
