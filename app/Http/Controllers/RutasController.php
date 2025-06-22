<?php

namespace App\Http\Controllers;

use App\Models\Rutas;
use Illuminate\Http\Request;

class RutasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rutas = Rutas::select('id', 'NombreRuta')->orderByDesc('id')->paginate(10);

        return response()->json($rutas);
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rutas  $rutas
     * @return \Illuminate\Http\Response
     */
    public function show(Rutas $rutas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rutas  $rutas
     * @return \Illuminate\Http\Response
     */
    public function edit(Rutas $rutas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rutas  $rutas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $modelo = Rutas::findOrFail($id); // o Rutas::findOrFail($id)
        $modelo->update($request->only(['NombreZona'])); // o NombreRuta
        return response()->json(['message' => 'Actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rutas  $rutas
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $modelo = Rutas::findOrFail($id); // o Zonas::findOrFail($id)
        $modelo->delete();

        return response()->json(['message' => 'Eliminado correctamente']);
    }
}
