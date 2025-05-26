<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Materia;
use App\Models\Carrera;
use App\Models\Alumno;
use App\Models\Profesor;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);

        

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calificaciones = Calificacion::with('materia', 'carrera', 'alumno', 'profesor')->orderByDesc('id')->get();
        return view('sistema.calificacion.index', compact('calificaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $materias = Materia::all(); // Obtén todas las materias
        $carreras = Carrera::all(); // Obtén todas las carreras
        $alumnos = Alumno::all(); // Obtén todos los alumnos
        $profesores = Profesor::all(); // Obtén todos los profesores
        return view('sistema.calificacion.create', compact('materias', 'carreras', 'alumnos', 'profesores'));
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
        'calificacion' => 'required',
        'materia_id' => 'required',
        'carrera_id' => 'required',
        'alumno_id' => 'required',
        'profesor_id' => 'required',

        ]);
        /* Creating a new Huesped object and then redirecting to the index page. */
        // Crear un nuevo profesor con los datos del formulario
        $calificacion = Calificacion::create($datos);

        // Guardar la relación con la materia
        $calificacion->materia_id = $request->input('materia_id');
        $calificacion->save();

        // Guardar la relación con la materia
        $calificacion->carrera_id = $request->input('carrera_id');
        $calificacion->save();

        $calificacion->alumno_id = $request->input('alumno_id');
        $calificacion->save();

        $calificacion->profesor_id = $request->input('profesor_id');
        $calificacion->save();

        return redirect()->route('calificacion.index');
        $id = Calificacion::create($datos);
        return redirect()->route('calificacion.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $calificacion = Calificacion::find($id);
        $carreras = Carrera::all();
        $materias = Materia::all();
        $alumnos = Alumno::all();
        $profesores = Profesor::all();

        return view('sistema.calificacion.edit', compact('materias', 'alumnos', 'carreras', 'profesores', 'calificacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calificacion $calificacion)
    {
        $request->validate([
            'calificacion' => 'required',
            'materia_id' => 'required',
            'carrera_id' => 'required',
            'alumno_id' => 'required',
            'profesor_id' => 'required',
        ]);

        $calificacion->update($request->all());

        return redirect()->route('calificacion.index')
            ->with('success', 'Calificacion actualizada correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
