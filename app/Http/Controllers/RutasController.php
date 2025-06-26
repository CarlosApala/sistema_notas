<?php

namespace App\Http\Controllers;

use App\Models\Rutas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class RutasController extends Controller
{
    public function index()
    {
        $rutas = Rutas::select('id', 'NombreRuta')->orderByDesc('id')->paginate(10);

        return response()->json($rutas);
    }


    public function create()
    {
        try {
            // Si necesitas enviar datos adicionales (por ejemplo, listas para selects), aquí puedes hacerlo.
            // En este caso, simplemente retornamos la vista sin datos adicionales.

            return Inertia::render('sistema/Rutas/Create');
        } catch (\Exception $e) {
            Log::error("Error al cargar formulario de creación de personal interno: {$e->getMessage()}");
            return redirect()->back()->with('error', 'No se pudo cargar el formulario de creación.');
        }
    }

    public function store(Request $request)
    {


        $request->validate([
            'NombreRuta' => 'required|string|max:100|unique:rutas,NombreRuta',
        ]);

        Rutas::create([
            'NombreRuta' => $request->NombreRuta,
        ]);

        return back()->with('success', 'Ruta registrada correctamente.');

        return redirect()->back()->with([
            'success' => 'Ruta registrada correctamente.',
            'nuevaRuta' => $request->NombreRuta, // <- devuelto al frontend
        ]);
    }

    public function show(Rutas $rutas)
    {
        //
    }

    public function edit(Rutas $rutas)
    {
        //
    }
    public function update(Request $request, $id)
    {
        $modelo = Rutas::findOrFail($id); // o Rutas::findOrFail($id)
        $modelo->update($request->only(['NombreZona'])); // o NombreRuta
        return redirect()->back(); // o redirect('/sistema/rutas') según convenga

        //return response()->json(['message' => 'Actualizado correctamente']);
    }


    public function destroy($id)
    {
        try {
            $ruta = Rutas::findOrFail($id);
            $ruta->delete();

            return redirect()->back(); // o redirect('/sistema/rutas') según convenga
            // O solo
            // return response()->noContent();
        } catch (\Exception $e) {
            Log::error("Error al eliminar registro: {$e->getMessage()}");

            return response()->json(['error' => 'No se pudo eliminar el registro.'], 500);
        }
    }
}
