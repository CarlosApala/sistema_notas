<?php

namespace App\Http\Controllers;

use App\Models\Instalacion;
use App\Models\Predio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class InstalacionController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $onlyDeleted = $request->boolean('deleted');

            // Consultar instalaciones con relación a predio
            $query = Instalacion::with('predio');

            if ($onlyDeleted) {
                $query->onlyTrashed();
            }

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('NumeroMedidor', 'ilike', "%{$search}%")
                        ->orWhere('EstadoInstalacion', 'ilike', "%{$search}%")
                        ->orWhere('EstadoAlcantarillado', 'ilike', "%{$search}%")
                        ->orWhere('EstadoCorte', 'ilike', "%{$search}%")
                        ->orWhereHas('predio', function ($q2) use ($search) {
                            $q2->where('direccion', 'ilike', "%{$search}%")
                                ->orWhere('zonaBarrio', 'ilike', "%{$search}%")
                                ->orWhere('distrito', 'ilike', "%{$search}%");
                        });
                });
            }

            // Sin select para traer todos los campos y relación
            $instalaciones = $query
                ->orderBy('id', 'asc')
                ->paginate(10)
                ->appends($request->query());

            return Inertia::render('sistema/Instalaciones/Index', [
                'instalaciones' => $instalaciones,
                'filters' => [
                    'search' => $search,
                    'deleted' => $onlyDeleted,
                ],
                'flash' => [
                    'success' => session('success'),
                    'error' => session('error'),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Error en index de Instalaciones: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Ocurrió un error al cargar las instalaciones.');
        }
    }

    public function create()
    {
        return Inertia::render('sistema/Instalaciones/Create');
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'idPredio' => 'required|exists:predio,id',
            'FechaInstalacion' => 'nullable|date',
            'NumeroMedidor' => 'nullable|string|max:255',
            'EstadoInstalacion' => 'nullable|string|max:255',
            'EstadoAlcantarillado' => 'nullable|string|max:255',
            'Observaciones' => 'nullable|string',
            'NroGrifos' => 'nullable|integer|min:0',
            'NroBaños' => 'nullable|integer|min:0',
            'EstadoCorte' => 'nullable|string|max:255',
            'PromedioConsumo' => 'nullable|numeric|min:0',
            'CodigoUbicacion' => 'nullable|string|max:255',
        ]);

        try {
            Instalacion::create($validated);

            return redirect()
                ->route('instalaciones.index')
                ->with('success', 'Instalación creada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar instalación: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withErrors(['error' => 'Hubo un problema al guardar la instalación.'])
                ->withInput();
        }
    }


    public function show($id)
    {
        try {
            // Buscar la instalación con la relación 'predio'
            $instalacion = Instalacion::with('predio')->findOrFail($id);

            return Inertia::render('sistema/Instalaciones/Show', [
                'instalacion' => $instalacion,
            ]);
        } catch (\Exception $e) {
            Log::error("Error al mostrar la instalación id $id: " . $e->getMessage());

            return redirect()->route('instalaciones.index')
                ->with('error', 'No se pudo cargar la instalación solicitada.');
        }
    }

    public function edit($id)
    {
        try {
            $instalacion = Instalacion::with('predio')->findOrFail($id);
            $predios = Predio::all(); // para el <select>

            return Inertia::render('sistema/Instalaciones/Edit', [
                'instalacion' => $instalacion,
                'predios' => $predios,
            ]);
        } catch (\Exception $e) {
            Log::error("Error al cargar instalación para editar: {$e->getMessage()}");
            return redirect()->back()->with('error', 'No se pudo cargar la instalación.');
        }
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'idPredio' => 'required|exists:predio,id',
            'FechaInstalacion' => 'nullable|date',
            'NumeroMedidor' => 'nullable|string|max:255',
            'EstadoInstalacion' => 'nullable|string|max:255',
            'EstadoAlcantarillado' => 'nullable|string|max:255',
            'Observaciones' => 'nullable|string',
            'NroGrifos' => 'nullable|integer|min:0',
            'NroBanos' => 'nullable|integer|min:0',
            'EstadoCorte' => 'nullable|string|max:255',
            'PromedioConsumo' => 'nullable|numeric|min:0',
            'CodigoUbicacion' => 'nullable|string|max:255',
        ]);

        try {
            $instalacion = Instalacion::findOrFail($id);

            $instalacion->update($request->only([
                'idPredio',
                'FechaInstalacion',
                'NumeroMedidor',
                'EstadoInstalacion',
                'EstadoAlcantarillado',
                'Observaciones',
                'NroGrifos',
                'NroBanos',
                'EstadoCorte',
                'PromedioConsumo',
                'CodigoUbicacion',
            ]));

            return redirect()->route('instalaciones.index')->with('success', 'Instalación actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al actualizar instalación: {$e->getMessage()}");
            return redirect()->back()->withErrors('No se pudo actualizar la instalación.')->withInput();
        }
    }

    public function destroy(Instalacion $instalacion)
    {
        $instalacion->delete();

        return response()->json(['message' => 'Instalación eliminada']);
    }
}
