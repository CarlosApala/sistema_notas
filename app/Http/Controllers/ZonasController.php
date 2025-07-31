<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Zonas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ZonasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index(Request $request)
    {
        $query = Zonas::query();

        if ($request->boolean('deleted')) {
            $query->onlyTrashed();
        }

        if ($search = $request->input('search')) {
            $query->where('NombreZona', 'like', "%{$search}%");
        }

        $zonas = $query->orderBy('id', 'asc')->paginate($request->get('per_page', 10))->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($zonas);
        }

        return Inertia::render('sistema/Zonas/Index', [
            'zonas' => $zonas,
            'filters' => $request->only('search', 'deleted'),
            'flash' => [
                'success' => session('success'),
            ],
        ]);
    }

    public function indexEdit(Request $request)
    {
        $query = Zonas::query();

        if ($request->boolean('deleted')) {
            $query->onlyTrashed();
        }

        if ($search = $request->input('search')) {
            $query->where('NombreZona', 'like', "%{$search}%");
        }

        $zonas = $query->orderBy('id', 'asc')->paginate($request->get('per_page', 10))->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($zonas);
        }

        return Inertia::render('sistema/Zonas/IndexEdit', [
            'zonas' => $zonas,
            'filters' => $request->only('search', 'deleted'),
            'flash' => [
                'success' => session('success'),
            ],
        ]);
    }

    public function indexDelete(Request $request)
    {
        $query = Zonas::query();

        if ($request->boolean('deleted')) {
            $query->onlyTrashed();
        }

        if ($search = $request->input('search')) {
            $query->where('NombreZona', 'like', "%{$search}%");
        }

        $zonas = $query->orderBy('id', 'asc')->paginate($request->get('per_page', 10))->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($zonas);
        }

        return Inertia::render('sistema/Zonas/IndexDelete', [
            'zonas' => $zonas,
            'filters' => $request->only('search', 'deleted'),
            'flash' => [
                'success' => session('success'),
            ],
        ]);
    }




    public function indexRegistros(Request $request)
    {
        $query = Zonas::query();

        dd('hola mundo');

        if ($request->filled('search')) {
            $query->where('NombreZona', 'like', '%' . $request->search . '%');
        }

        if ($request->boolean('deleted')) {
            $query->onlyTrashed();
        }

        $zonas = $query->orderBy('id', 'asc')->paginate($request->get('per_page', 10))->withQueryString();

        // Si es petición fetch (por el componente), retornamos JSON
        if ($request->wantsJson()) {
            return response()->json($zonas);
        }

        // Si no, es una carga inicial desde navegador
        return Inertia::render('sistema/Zonas/Index', [
            'fetchUrl' => route('zonas.indexRegistros'),
            'flash' => [
                'success' => session('success'),
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('sistema/Zonas/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'NombreZona' => 'required|string|max:100|unique:zonas,NombreZona',
        ]);

        Zonas::create([
            'NombreZona' => $request->NombreZona,
        ]);

        return redirect()->back()->with('success', 'Zona registrada correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zonas  $zonas
     * @return \Illuminate\Http\Response
     */
    public function show(Zonas $zonas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Zonas  $zonas
     * @return \Illuminate\Http\Response
     */
    public function edit(Zonas $zonas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Zonas  $zonas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $zona = Zonas::findOrFail($id);
        $zona->NombreZona = $request->NombreZona;
        $zona->save();

        return redirect()->back()->with('success', 'Zona actualizada correctamente.');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zonas  $zonas
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        try {
            $ruta = Zonas::findOrFail($id);
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
