<?php

namespace App\Http\Controllers;

use App\Models\Programa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class ProgramaController extends Controller
{
    // Mostrar listado paginado con búsqueda (GET /programas)
    public function index(Request $request)
    {
        $query = Permission::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nombre', 'LIKE', "%{$search}%");
        }

        $programas = $query->orderBy('id', 'desc')
            ->paginate($request->per_page ?? 10)
            ->withQueryString();

        return inertia('programas/Index', [
            'programas' => [
                'data' => $programas->items(),
                'links' => $programas->links(),
                'total' => $programas->total(),
                'per_page' => $programas->perPage(),
                'current_page' => $programas->currentPage(),
            ],
        ]);
    }



    // Mostrar formulario para crear (GET /programas/create)
    public function create()
    {
        return inertia('programas/Create');
    }

    // Guardar nuevo programa (POST /programas)
    public function store(Request $request)
    {
        /* $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        try {
            Programa::create($validated);

            return redirect()->route('programas.create')->with('success', 'Programa creado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar programa: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Hubo un problema al guardar el programa.']);
        } */
    }


}
