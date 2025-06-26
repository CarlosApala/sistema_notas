<?php

namespace App\Http\Controllers;

use App\Models\Rutas;
use App\Models\Zonas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ZonasRutaController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $onlyDeleted = $request->boolean('deleted');

            $query = Zonas::query();

            if ($onlyDeleted) {
                $query->onlyTrashed();
            }

            if ($search) {
                $query->where('NombreZona', 'ilike', "%{$search}%");
            }

            // Cargar rutas asociadas que no estén soft-deleted
            $query->with(['rutas' => function ($q) {
                $q->select('id', 'NombreRuta', 'zona_id')
                    ->whereNull('deleted_at');
            }]);

            $zonas = $query->select('id', 'NombreZona')
                ->orderByDesc('id')
                ->paginate(10)
                ->appends($request->query());

            return Inertia::render('sistema/Zonas_Rutas/Index', [
                'zonas' => $zonas,
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
            Log::error('Error al listar zonas: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Ocurrió un error al obtener las zonas.');
        }
    }


    public function show($id)
    {
        $zona = Zonas::with('rutas')->findOrFail($id);

        // Por ejemplo, enviar solo campos necesarios de rutas
        $rutas = $zona->rutas->map(fn($ruta) => [
            'id' => $ruta->id,
            'NombreRuta' => $ruta->NombreRuta,
        ]);

        return Inertia::render('sistema/Zonas_Rutas/Show', [
            'zona' => [
                'id' => $zona->id,
                'NombreZona' => $zona->NombreZona,
                'rutas' => $rutas,
            ],
        ]);
    }

    public function store(Request $request)
    {


        $request->validate([
            'NombreRuta' => 'required|string|max:255',
            'zona_id' => 'required|exists:zonas,id',
        ]);

        try {
            Rutas::create([
                'NombreRuta' => $request->NombreRuta,
                'zona_id' => $request->zona_id,
            ]);

            return redirect()->back()->with('success', 'Ruta registrada correctamente');
        } catch (\Exception $e) {
            // Aquí puedes loguear el error si quieres:
            // Log::error('Error al registrar ruta: '.$e->getMessage());

            return redirect()->back()
                ->with('error', 'Error al registrar la ruta. Intente nuevamente.');
        }
    }
    public function destroy($id)
    {
        try {
            $zona = Zonas::findOrFail($id);
            $zona->delete();

            return redirect()->back()->with('success', 'Zona eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la zona.');
        }
    }

    public function actualizarRuta(Request $request, $id)
    {
        $request->validate([
            'NombreRuta' => 'required|string|max:255',
            'zona_id' => 'required|exists:zonas,id',
        ]);

        try {
            $ruta = Rutas::findOrFail($id);
            $ruta->update([
                'NombreRuta' => $request->NombreRuta,
                'zona_id' => $request->zona_id,
            ]);

            return redirect()->back()->with('success', 'Ruta actualizada correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la ruta.');
        }
    }
    public function eliminarRuta(Rutas $ruta)
    {
        try {
            $ruta->delete(); // Esto hará soft delete si tienes SoftDeletes, si no elimina permanentemente

            return redirect()->back()->with('success', 'Ruta eliminada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar ruta: ' . $e->getMessage());
            return redirect()->back()->with('error', 'No se pudo eliminar la ruta. Intente nuevamente.');
        }
    }
}
