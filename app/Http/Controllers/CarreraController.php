<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
        $this->middleware('role:admin')->only(['create', 'store', 'edit', 'update', 'show', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carreras = Carrera::orderByDesc('id')->get();
        return view('sistema.carreras.index', compact('carreras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("sistema.carreras.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required',
            'clave' => 'required',
            'descripcion' => 'required',
            'imagen' => 'nullable',

        ]);
        $id = Carrera::create($datos);
        return redirect()->route('carreras.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function show(Carrera $carrera)
    {
        return view("sistema.carreras.show", ['carrera' => $carrera]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function edit(Carrera $carrera)
    {
        return view('sistema.carreras.edit', compact('carrera'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carrera $carrera)
    {
        $request->validate([
            'nombre' => 'required',
            'clave' => 'required|numeric',
            'descripcion' => 'required',


        ]);
        $carrera->update($request->all());
        return redirect()->route('carreras.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carrera $carrera)
    {
        $carrera->delete();
        return redirect()->route('carreras.index');
    }
}
