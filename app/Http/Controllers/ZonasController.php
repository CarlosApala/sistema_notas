<?php

namespace App\Http\Controllers;

use App\Models\Zonas;
use Illuminate\Http\Request;

class ZonasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zonas = Zonas::select('id', 'NombreZona')->orderByDesc('id')->paginate(10);

        return response()->json($zonas);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        return redirect()->back()->with([
            'success' => 'Zona registrada correctamente.',
            'nuevaZona' => $request->NombreZona, // <- devuelto al frontend
        ]);
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
        $modelo = Zonas::findOrFail($id); // o Rutas::findOrFail($id)
        $modelo->update($request->only(['NombreZona'])); // o NombreRuta
        return response()->json(['message' => 'Actualizado correctamente']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zonas  $zonas
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $modelo = Zonas::findOrFail($id); // o Zonas::findOrFail($id)
        $modelo->delete();

        return response()->json(['message' => 'Eliminado correctamente']);
    }
}
