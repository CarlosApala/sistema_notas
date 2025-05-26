<?php

namespace App\Http\Controllers;
use App\Models\Materia;
use App\Models\Carrera;
use App\Models\Profesor;
use Illuminate\Http\Request;

class MateriaController extends Controller
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
        $materias = Materia::with('carrera', 'profesor')->orderBy('id')->get();
        return view('sistema.materias.index', compact('materias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $profesores = Profesor::all(); // Obtén todas las materias
        $carreras = Carrera::all(); // Obtén todas las carreras
        return view('sistema.materias.create', compact('profesores', 'carreras'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datos = $request->validate ([
            'nombre' => 'required',
            'codigo' => 'required',
            'creditos' => 'required',
            'descripcion' => 'required',
            'carrera_id' => 'nullable',
            'profesor_id' => 'nullable',

        ]);
        $id = Materia::create($datos );
        return redirect()->route('materias.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Materia  $habitacion
     * @return \Illuminate\Http\Response
     */
    public function show(Materia $materia)
    {
        return view("sistema.materias.show",['materia'=>$materia]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Habitacion  $habitacion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $materias = Materia::find($id);
        $carreras = Carrera::all();
        $profesores = Profesor::all();

        return view('sistema.materias.edit', compact('materias', 'profesores', 'carreras'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Habitacion  $habitacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Materia $materia)
    {
        $request->validate ([
            'nombre' => 'required',
            'codigo' => 'required',
            'creditos' => 'required | numeric | min:1 | max:5',
            'descripcion' => 'required',
            'carrera_id' => 'required',
            'profesor_id' => 'required',


        ]);
        $materia->update($request->all());
        return redirect()->route('materias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Habitacion  $habitacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Materia $materias)
    {
        $materias->delete();
        return redirect()->route('materias.index');
    }
}
