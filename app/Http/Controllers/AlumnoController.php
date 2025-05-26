<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\User;
use App\Models\Materia;
use App\Models\Carrera;
use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Turno;
use App\Models\Paralelo;
use Illuminate\Support\Facades\DB;

class AlumnoController extends Controller
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
        $alumnos = Alumno::with(['curso', 'turno', 'paralelo'])->orderByDesc('id')->get();
        return view('sistema.alumno.index', compact('alumnos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $cursos = Curso::all();
        $turnos = Turno::all();
        $paralelos = Paralelo::all();

        return view('sistema.alumno.create', compact('cursos', 'turnos', 'paralelos'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        try {
            $datos = $request->validate([
                'nombre' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'matricula' => 'required',
                'direccion' => 'required',
                'telefono' => 'required',
                'semestre' => 'nullable',
                'fecha_nacimiento' => 'required|date',
                'sexo' => 'nullable',
                'edad' => 'required|integer',
                'curp' => 'required',
                'fecha_ingreso' => 'required|date',
                'estatus' => 'nullable',
                'observaciones' => 'nullable',

                'curso_id' => 'required|exists:cursos,id',
                'turno_id' => 'required|exists:turnos,id',
                'paralelo_id' => 'required|exists:paralelos,id',
                // 🔴 Elimina la validación de 'materias'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        // Crear alumno
        $alumno = Alumno::create($datos);

        // Crear usuario
        $user = User::create([
            'name' => $datos['nombre'],
            'email' => $datos['email'],
            'username' => strtolower(str_replace(' ', '.', $datos['nombre'])),
            'password' => '12345678',
        ]);

        $user->assignRole('alumno');

        // 🔄 Obtener todas las asignaciones del curso (con turno y paralelo)
        $asignaciones = DB::table('materia_curso_profesor')
            ->where('curso_id', $datos['curso_id'])
            ->where('turno_id', $datos['turno_id'])
            ->where('paralelo_id', $datos['paralelo_id'])
            ->pluck('id');

        // 🔁 Relacionar alumno con esas asignaciones
        $alumno->materiasAsignadas()->sync($asignaciones);

        return redirect()->route('alumno.index')->with('success', 'Alumno y usuario creados correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Alumno $alumno)
    {
        $alumno->load('curso', 'turno', 'paralelo', 'materiasCursoProfesor.materia');
        return view('sistema.alumno.show', compact('alumno'));
    }





    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $alumno = Alumno::findOrFail($id);
        $cursos = Curso::all();
        $turnos = Turno::all();
        $paralelos = Paralelo::all();

        return view('sistema.alumno.edit', compact('alumno', 'cursos', 'turnos', 'paralelos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Alumno $alumno)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required',
            'matricula' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'semestre' => 'required',
            'fecha_nacimiento' => 'required',
            'sexo' => 'nullable',
            'edad' => 'required',
            'curp' => 'required',
            'fecha_ingreso' => 'required',
            'estatus' => 'nullable',
            'observaciones' => 'nullable',

            'curso_id' => 'required',
            'turno_id' => 'required',
            'paralelo_id' => 'required',
        ]);

        $alumno->update($request->all());

        return redirect()->route('alumno.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return redirect()->route('alumno.index');
    }
}
