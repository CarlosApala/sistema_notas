<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Turno;
use App\Models\Paralelo;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{

    public function index()
    {
        $cursos = Curso::with(['turno', 'paralelo', 'materias'])->get();
        return view('sistema.cursos.index', compact('cursos'));
    }


    public function create()
    {
        $turnos = Turno::all();
        $paralelos = Paralelo::all();
        $materias = Materia::all();

        return view('sistema.cursos.create', compact('turnos', 'paralelos', 'materias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'turno_id' => 'required|exists:turnos,id',
            'paralelo_id' => 'required|exists:paralelos,id',
            'materias' => 'required|array',
            'materias.*' => 'exists:materias,id',
        ]);

        $curso = Curso::create([
            'nombre' => $request->nombre,
            'turno_id' => $request->turno_id,
            'paralelo_id' => $request->paralelo_id,
        ]);

        // Asumiendo que tienes la tabla pivote materia_curso_profesor sin profesor aún asignado:
        foreach ($request->materias as $materiaId) {
            DB::table('materia_curso_profesor')->insert([
                'curso_id' => $curso->id,
                'materia_id' => $materiaId,
                'profesor_id' => null, // se asignará después
                'paralelo_id' => $curso->paralelo_id,
                'turno_id' => $curso->turno_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('cursos.index')->with('success', 'Curso creado con materias asignadas.');
    }


    public function show(Curso $curso)
    {
        // Cargar relaciones si no están incluidas automáticamente
        $curso->load('turno', 'paralelo', 'materias');

        return view('sistema.cursos.show', compact('curso'));
    }

    // Mostrar formulario para editar curso
    public function edit(Curso $curso)
    {
        return view('sistema.cursos.edit', compact('curso'));
    }

    // Actualizar curso
    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $curso->update($request->all());

        return redirect()->route('sistema.cursos.index')->with('success', 'Curso actualizado correctamente.');
    }

    // Eliminar curso
    public function destroy(Curso $curso)
    {
        $curso->delete();

        return redirect()->route('sistema.cursos.index')->with('success', 'Curso eliminado correctamente.');
    }
}
