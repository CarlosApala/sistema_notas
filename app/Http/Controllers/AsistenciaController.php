<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Alumno;
use App\Models\Materia;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class AsistenciaController extends Controller
{

    // Mostrar formulario de creación
    public function create()
{
    $alumnos = Alumno::all();
    return view('sistema.asistencias.create', compact('alumnos'));
}


    // Guardar asistencia
    public function store(Request $request)
{
    $request->validate([
        'fecha' => 'required|date',
        'asistencia' => 'array',
    ]);

    $fecha = $request->input('fecha');
    $asistencias = $request->input('asistencia', []);

    $alumnos = Alumno::all();

    foreach ($alumnos as $alumno) {
        // Si no hay checkbox para este alumno, asumimos que no asistió (false)
        $asistio = isset($asistencias[$alumno->id]);

        // Crear o actualizar la asistencia
        Asistencia::updateOrCreate(
            [
                'alumno_id' => $alumno->id,
                'fecha' => $fecha,
            ],
            [
                'materia_id' => null, // Si quieres asignar materia, ajusta esto
                'hora' => now()->format('H:i:s'),
                'asistio' => $asistio,
            ]
        );
    }

    return redirect()->route('asistencias.index')->with('success', 'Asistencia guardada correctamente.');
}

public function edit(Asistencia $asistencia)
{
    $alumnos = Alumno::all();
    $materias = Materia::all();

    $inicioSemana = \Carbon\Carbon::parse($asistencia->fecha)->startOfWeek(); // lunes
    $fechasSemana = collect();
    for ($i = 0; $i < 6; $i++) {
        $fechasSemana->push($inicioSemana->copy()->addDays($i)->toDateString());
    }

    $asistenciasSemana = Asistencia::where('alumno_id', $asistencia->alumno_id)
        ->whereIn('fecha', $fechasSemana)
        ->get()
        ->keyBy('fecha');

    return view('sistema.asistencias.edit', compact(
        'asistencia',
        'alumnos',
        'materias',
        'fechasSemana',
        'asistenciasSemana'
    ));
}




    // Mostrar el formulario para editar asistencia
public function show(Asistencia $asistencia)
{
    $inicioSemana = Carbon::parse($asistencia->fecha)->startOfWeek(); // lunes
    $fechasSemana = collect();
    for ($i = 0; $i < 6; $i++) {
        $fechasSemana->push($inicioSemana->copy()->addDays($i)->toDateString());
    }

    $asistenciasSemana = Asistencia::where('alumno_id', $asistencia->alumno_id)
        ->whereIn('fecha', $fechasSemana)
        ->get()
        ->keyBy('fecha');

    return view('sistema.asistencias.show', compact(
        'asistencia',
        'fechasSemana',
        'asistenciasSemana'
    ));
}



// Actualizar la asistencia
public function update(Request $request, Asistencia $asistencia)
{
    $request->validate([
        'alumno_id' => 'required|exists:alumnos,id',
        'materia_id' => 'required|exists:materias,id',
        'fechas'     => 'required|array',
    ]);

    $alumno_id = $request->input('alumno_id');
    $materia_id = $request->input('materia_id');
    $fechas = $request->input('fechas');
    $asistio = $request->input('asistio', []);
    $horas = $request->input('hora', []);

    foreach ($fechas as $fecha) {
        Asistencia::updateOrCreate(
            [
                'alumno_id' => $alumno_id,
                'fecha' => $fecha,
            ],
            [
                'materia_id' => $materia_id,
                'hora' => $horas[$fecha] ?? now()->format('H:i:s'),
                'asistio' => isset($asistio[$fecha]),
            ]
        );
    }

    return redirect()->route('sistema.asistencias.index')->with('success', 'Asistencias actualizadas correctamente.');
}



    // Eliminar asistencia
    public function destroy(Asistencia $asistencia)
    {
        $asistencia->delete();
        return redirect()->route('asistencias.index')->with('success', 'Asistencia eliminada.');
    }

    public function index()
{
    $alumnos = Alumno::all();

    // Obtener el lunes de la semana actual
    $lunes = Carbon::now()->startOfWeek(); // Por defecto, Carbon usa lunes como inicio de semana

    // Crear colección de fechas desde lunes hasta sábado
    $fechas = collect();
    for ($i = 0; $i < 6; $i++) { // 6 días: lunes a sábado
        $fechas->push($lunes->copy()->addDays($i)->toDateString());
    }

    // Obtener asistencias en ese rango de fechas
    $asistencias = Asistencia::whereIn('fecha', $fechas)->get()->groupBy(function($item) {
        return $item->alumno_id . '_' . $item->fecha;
    });

    return view('sistema.asistencias.index', compact('alumnos', 'fechas', 'asistencias'));
}



    // Guardar asistencia en lote
    public function batchStore(Request $request)
    {
        $materia_id = $request->input('materia_id');
        $asistencias = $request->input('asistencia', []);

        foreach ($asistencias as $alumno_id => $dias) {
            foreach ($dias as $fecha => $valor) {
                Asistencia::updateOrCreate(
                    [
                        'alumno_id' => $alumno_id,
                        'materia_id' => $materia_id,
                        'fecha' => $fecha,
                    ],
                    [
                        'hora' => Carbon::now()->format('H:i:s'),
                        'asistio' => (bool)$valor,
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Asistencia guardada correctamente.');
    }

    // Mostrar todas las asistencias registradas (opcional)
    public function showAll()
    {
        $asistencias = Asistencia::with(['alumno', 'materia'])->orderBy('fecha', 'desc')->get();
        return view('asistencias.lista', compact('asistencias'));
    }

}

