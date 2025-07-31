<?php

namespace App\Http\Controllers;

use App\Models\Predio;
use App\Models\Zonas;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class PredioController extends Controller
{
    public function listJson()
    {
        return response()->json(\App\Models\Predio::select('id', 'direccion', 'zonaBarrio', 'distrito')->get());
    }
    public function index(Request $request)
    {
        $query = Predio::query();

        // Si pide ver solo eliminados
        if ($request->boolean('deleted')) {
            $query->onlyTrashed();
        }

        // Filtro de búsqueda (dirección, zonaBarrio, distrito)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('direccion', 'ILIKE', "%{$search}%")
                    ->orWhere('zonaBarrio', 'ILIKE', "%{$search}%")
                    ->orWhere('distrito', 'ILIKE', "%{$search}%");
            });
        }

        // Ordenar por ID ascendente
        $predios = $query->orderBy('id', 'asc')->paginate(10)->withQueryString();

        return Inertia::render('sistema/Predios/Index', [
            'predios' => $predios,
            'filters' => $request->only('search', 'deleted'),
            'flash' => [
                'success' => session('success'),
            ],
        ]);
    }

    public function indexEdit(Request $request)
    {
        $query = Predio::query();

        // Si pide ver solo eliminados
        if ($request->boolean('deleted')) {
            $query->onlyTrashed();
        }

        // Filtro de búsqueda (dirección, zonaBarrio, distrito)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('direccion', 'ILIKE', "%{$search}%")
                    ->orWhere('zonaBarrio', 'ILIKE', "%{$search}%")
                    ->orWhere('distrito', 'ILIKE', "%{$search}%");
            });
        }

        // Ordenar por ID ascendente
        $predios = $query->orderBy('id', 'asc')->paginate(10)->withQueryString();

        return Inertia::render('sistema/Predios/IndexEdit', [
            'predios' => $predios,
            'filters' => $request->only('search', 'deleted'),
            'flash' => [
                'success' => session('success'),
            ],
        ]);
    }

    public function indexDelete(Request $request)
    {
        $query = Predio::query();

        // Si pide ver solo eliminados
        if ($request->boolean('deleted')) {
            $query->onlyTrashed();
        }

        // Filtro de búsqueda (dirección, zonaBarrio, distrito)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('direccion', 'ILIKE', "%{$search}%")
                    ->orWhere('zonaBarrio', 'ILIKE', "%{$search}%")
                    ->orWhere('distrito', 'ILIKE', "%{$search}%");
            });
        }

        // Ordenar por ID ascendente
        $predios = $query->orderBy('id', 'asc')->paginate(10)->withQueryString();

        return Inertia::render('sistema/Predios/IndexDelete', [
            'predios' => $predios,
            'filters' => $request->only('search', 'deleted'),
            'flash' => [
                'success' => session('success'),
            ],
        ]);
    }

    public function show($id)
    {
        try {
            // Buscar el predio, incluyendo relaciones si las tienes (aquí sin relaciones)
            $predio = \App\Models\Predio::withTrashed()->findOrFail($id);


            return Inertia::render('sistema/Predios/Show', [
                'predio' => $predio,
            ]);
        } catch (\Exception $e) {
            Log::error("Error al mostrar el predio id $id: " . $e->getMessage());

            return redirect()->route('predios.index')
                ->with('error', 'No se pudo cargar el predio solicitado.');
        }
    }
    public function edit($id)
    {
        try {
            $predio = Predio::findOrFail($id);

            // Si necesitas enviar más datos relacionados (ejemplo: listas para selects),
            // puedes agregarlos aquí. Por ahora, solo envío el predio.

            return Inertia::render('sistema/Predios/Edit', [
                'predio' => $predio,
            ]);
        } catch (\Exception $e) {
            Log::error("Error al cargar predio para editar: {$e->getMessage()}");
            return redirect()->back()->with('error', 'No se pudo cargar el predio.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'direccion'       => 'required|string|max:255',
            'ubicaciongps'    => 'nullable|string|max:255',
            'zonaBarrio'      => 'nullable|string|max:255',
            'distrito'        => 'nullable|string|max:255',
            'UnidadVecinal'   => 'nullable|string|max:255',
            'Manzana'         => 'nullable|string|max:255',
            'AreaPredio'      => 'nullable|numeric|min:0',
            'LongitudFrente'  => 'nullable|numeric|min:0',
            'AreaConstruida'  => 'nullable|numeric|min:0',
            'NroHaitaciones'  => 'nullable|integer|min:0',
            'NroPisos'        => 'nullable|integer|min:0',
            'NroGrifos'       => 'nullable|integer|min:0',
            'NroBaños'        => 'nullable|integer|min:0',
            'TipoEdificacion' => 'nullable|string|max:255',
            'Pavimento'       => 'nullable|boolean',
            'EstadoEdificacion' => 'nullable|string|max:255',
            'PredioHabitado'  => 'nullable|boolean',
            'Observaciones'   => 'nullable|string',
        ]);

        try {
            $predio = Predio::findOrFail($id);

            $predio->update($request->only([
                'direccion',
                'ubicaciongps',
                'zonaBarrio',
                'distrito',
                'UnidadVecinal',
                'Manzana',
                'AreaPredio',
                'LongitudFrente',
                'AreaConstruida',
                'NroHaitaciones',
                'NroPisos',
                'NroGrifos',
                'NroBaños',
                'TipoEdificacion',
                'Pavimento',
                'EstadoEdificacion',
                'PredioHabitado',
                'Observaciones',
            ]));

            return redirect()->route('predios.index')->with('success', 'Predio actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al actualizar predio id $id: {$e->getMessage()}");
            return redirect()->back()->withErrors('No se pudo actualizar el predio.')->withInput();
        }
    }

    public function create()
    {
        try {
            // Obtener solo el campo NombreZona y paginar (10 por página como ejemplo)
            $zonas = Zonas::select('id', 'NombreZona')->get();

            return Inertia::render('sistema/Predios/Create', [
                'zonas' => $zonas,
            ]);
        } catch (\Exception $e) {
            Log::error("Error al cargar formulario de creación de predio: {$e->getMessage()}");
            return redirect()->back()->with('error', 'No se pudo cargar el formulario de creación.');
        }
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'direccion' => 'required|string|max:255',
            'ubicaciongps' => 'nullable|string|max:255',
            'zonaBarrio' => 'nullable|string|max:255',
            'distrito' => 'nullable|string|max:255',
            'UnidadVecinal' => 'nullable|string|max:255',
            'Manzana' => 'nullable|string|max:255',
            'AreaPredio' => 'nullable|numeric|min:0',
            'LongitudFrente' => 'nullable|numeric|min:0',
            'AreaConstruida' => 'nullable|numeric|min:0',
            'NroHaitaciones' => 'nullable|integer|min:0',
            'NroPisos' => 'nullable|integer|min:0',
            'NroGrifos' => 'nullable|integer|min:0',
            'NroBaños' => 'nullable|integer|min:0',
            'TipoEdificacion' => 'nullable|string|max:255',
            'Pavimento' => 'nullable|boolean',
            'EstadoEdificacion' => 'nullable|string|max:255',
            'PredioHabitado' => 'nullable|boolean',
            'Observaciones' => 'nullable|string',
        ]);

        try {
            Predio::create($validated);

            return redirect()
                ->route('predios.index')
                ->with('success', 'Predio creado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar predio: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withErrors(['error' => 'Hubo un problema al guardar el predio.'])
                ->withInput();
        }
    }
    public function destroy(Predio $predio)
    {
        $predio->delete();

        return redirect()->route('predios.index')
            ->with('success', 'Predio eliminado correctamente');
    }

    public function restore($id)
    {
        try {
            $predio = Predio::withTrashed()->findOrFail($id);
            $predio->restore();

            return redirect()->route('predios.index')
                ->with('success', 'Predio restaurado correctamente');
        } catch (\Exception $e) {
            Log::error("Error al restaurar predio: {$e->getMessage()}");
            return redirect()->back()->withErrors('No se pudo restaurar el predio');
        }
    }
}
