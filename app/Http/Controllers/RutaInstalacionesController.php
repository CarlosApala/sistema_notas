<?php

namespace App\Http\Controllers;

use App\Models\Predio;
use App\Models\RutaInstalaciones;
use App\Models\Rutas;
use App\Models\Zonas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RutaInstalacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    try {
        $search = $request->input('search');
        $onlyDeleted = $request->boolean('deleted');

        $query = RutaInstalaciones::leftJoin('zonas', 'ruta_instalaciones.idZona', '=', 'zonas.id')
            ->leftJoin('rutas', 'ruta_instalaciones.idRuta', '=', 'rutas.id')
            ->leftJoin('predio', 'ruta_instalaciones.idPredio', '=', 'predio.id')
            ->withTrashed();

        if ($onlyDeleted) {
            $query->whereNotNull('ruta_instalaciones.deleted_at');
        } else {
            $query->whereNull('ruta_instalaciones.deleted_at');
        }

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('ruta_instalaciones.nInstalacion', 'ilike', "%{$search}%")
                    ->orWhere('zonas.NombreZona', 'ilike', "%{$search}%")
                    ->orWhere('rutas.NombreRuta', 'ilike', "%{$search}%")
                    ->orWhere(function ($query2) use ($search) {
                        $query2->where('predio.direccion', 'ilike', "%{$search}%")
                            ->orWhere('predio.zonaBarrio', 'ilike', "%{$search}%")
                            ->orWhere('predio.distrito', 'ilike', "%{$search}%");
                    })
                    ->orWhereRaw(
                        "concat_ws('.', zonas.id::text, rutas.id::text, predio.id::text, ruta_instalaciones.\"nInstalacion\"::text) ilike ?",
                        ["%{$search}%"]
                    );
            });
        }

        $rutas = $query->select('ruta_instalaciones.*')
            ->paginate(10)
            ->withQueryString();

        return view('sistema.instalaciones.index', compact('rutas'));

    } catch (\Exception $e) {
        // Log del error si lo deseas
        Log::error('Error en index de RutaInstalaciones: ' . $e->getMessage());

        // Redirecciona con un mensaje de error
        return redirect()->back()->with('error', 'Ocurrió un error al buscar las instalaciones. Intenta nuevamente.');
    }
}





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zonas = Zonas::all();
        $rutas = Rutas::all();
        $predios = Predio::all();

        return view('sistema.instalaciones.create', compact('zonas', 'rutas', 'predios'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idZona' => 'required|exists:zonas,id',
            'idRuta' => 'required|exists:rutas,id',
            'idPredio' => 'required|exists:predio,id',
            'nInstalacion' => 'required|string|max:191',
        ]);

        RutaInstalaciones::create($validated);

        return redirect()->route('instalaciones.index')->with('success', 'Ruta de instalación creada correctamente.');
    }

    public function restore($id)
    {
        $instalacion = RutaInstalaciones::onlyTrashed()->findOrFail($id);
        $instalacion->restore();

        return redirect()->route('instalaciones.index', ['deleted' => true])
            ->with('success', 'Instalación restaurada correctamente.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RutaInstalaciones  $rutaInstalaciones
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Carga relaciones para evitar consultas N+1
        $rutaInstalaciones = RutaInstalaciones::findOrFail($id);

        // Retorna la vista con la variable $ruta
        return view('sistema.instalaciones.show', ['ruta' => $rutaInstalaciones]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RutaInstalaciones  $rutaInstalaciones
     * @return \Illuminate\Http\Response
     */
    // Mostrar formulario de edición
    public function edit($id)
    {
        $rutaInstalacion = RutaInstalaciones::findOrFail($id);

        // Puedes cargar relaciones si quieres mostrar datos relacionados
        $rutaInstalacion->load(['zona', 'ruta', 'predio']);

        // También puedes cargar listas para selects si tienes relaciones (ejemplo)
        $zonas = Zonas::all();
        $rutas = Rutas::all();
        $predios = Predio::all();

        return view('sistema.instalaciones.edit', compact('rutaInstalacion', 'zonas', 'rutas', 'predios'));
    }

    // Procesar la actualización
    public function update(Request $request, $id)
    {
        $rutaInstalacion = RutaInstalaciones::findOrFail($id);

        $validatedData = $request->validate([
            'idRuta' => 'required|exists:rutas,id',
            'idPredio' => 'required|exists:predios,id',
            'nInstalacion' => 'nullable|string|max:191',
            'idZona' => 'nullable|exists:zonas,id',
        ]);

        $rutaInstalacion->update($validatedData);

        return redirect()->route('ruta_instalaciones.show', $rutaInstalacion->id)
            ->with('success', 'Ruta instalación actualizada correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RutaInstalaciones  $rutaInstalaciones
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $instalacion = RutaInstalaciones::findOrFail($id);
        $instalacion->delete();

        return redirect()->route('instalaciones.index')
            ->with('success', 'Instalación eliminada correctamente.');
    }
}
