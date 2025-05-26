<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use App\Models\Materia;
use App\Models\Carrera;
use Illuminate\Http\Request;

class ProfesorController extends Controller
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
        $profesores = Profesor::with('materia', 'carrera')->orderByDesc('id')->get();
        return view('sistema.profesor.index', compact('profesores'));
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
        return view('sistema.profesor.create', compact('materias', 'carreras'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* Validating the data that is being sent to the database. */
        $datos = $request->validate([
            'nombre' => 'required',
            'email' => 'required',
            'cedula' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'experiencia' => 'required',
            'fecha_contratacion' => 'required',
            'materia_id' => 'nullable', // Asegúrate de incluir materia_id en la validación
            'carrera_id' => 'required',
        ]);
        /* Creating a new Huesped object and then redirecting to the index page. */
        // Crear un nuevo profesor con los datos del formulario
        $profesor = Profesor::create($datos);

        // Guardar la relación con la materia
        $profesor->materia_id = $request->input('materia_id');
        $profesor->save();

        // Guardar la relación con la materia
        $profesor->carrera_id = $request->input('carrera_id');
        $profesor->save();

        return redirect()->route('profesor.index');
        $id = Profesor::create($datos);
        return redirect()->route('profesor.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profesor  $profesor
     * @return \Illuminate\Http\Response
     */
    public function show(Profesor $profesor)
    {
        /* Returning the view of the show page. */
        return view("sistema.profesor.show", ['profesor' => $profesor]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profesor  $huesped
     * @return \Illuminate\Http\Response
     */
    /**
     * @param Profesor huesped The Huesped model instance that should be edited.
     */
    public function edit($id)
    {
        $profesor = Profesor::find($id);
        $carreras = Carrera::all();
        $materias = Materia::all();

        return view('sistema.profesor.edit', compact('materias', 'profesor', 'carreras'));
    }



    public function update(Request $request, Profesor $profesor)
    {
        /* Validating the data that is being sent to the database. */
        $request->validate([
            'nombre' => 'required',
            'email' => 'required',
            'direccion' => 'required',
            'experiencia' => 'required',
            'fecha_contratacion' => 'required',
            'materia_id' => 'required',
            'carrera_id' => 'required',
        ]);

        /* Updating the profesor object with the new data, including materia_id, and then redirecting to the index page. */
        $profesor->update($request->all());
        return redirect()->route('profesor.index');
    }


    public function destroy(Profesor $profesor)
    {
        /* Deleting the profesor object and then redirecting to the index page. */
        $profesor->delete();
        return redirect()->route('profesor.index');
    }
}
