<?php

namespace App\Http\Controllers;

use App\Models\RutaInstalaciones;
use App\Models\Rutas;
use App\Models\RutasLecturador;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RutasLecturadorController extends Controller
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

            $query = RutasLecturador::with(['rutaInstalacion', 'usuario']);

            if ($onlyDeleted) {
                $query->onlyTrashed();
            }

            if ($search) {
                $query->where(function ($q) use ($search) {
                    // Buscar por ID directamente en rutas_lecturador
                    $q->where('id', $search)
                        ->orWhereHas('rutaInstalacion', function ($q2) use ($search) {
                            $q2->where('nInstalacion', 'ilike', "%{$search}%")
                                ->orWhereHas('zona', fn($q3) => $q3->where('NombreZona', 'ilike', "%{$search}%"))
                                ->orWhereHas('ruta', fn($q4) => $q4->where('NombreRuta', 'ilike', "%{$search}%"))
                                ->orWhereHas('predio', function ($q5) use ($search) {
                                    $q5->where('direccion', 'ilike', "%{$search}%")
                                        ->orWhere('zonaBarrio', 'ilike', "%{$search}%")
                                        ->orWhere('distrito', 'ilike', "%{$search}%");
                                });
                        });
                });
            }

            $asignaciones = $query->select([
                'id',
                'idRuta',
                'idUser',
                'periodo',
                'created_at',
                'updated_at'
            ])
                ->paginate(10)
                ->appends($request->query());

            return view('sistema.lecturadores.index', compact('asignaciones'));
        } catch (\Exception $e) {
            Log::error('Error en index de RutasLecturador: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al buscar las asignaciones. Intenta nuevamente.');
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rutas = RutaInstalaciones::with('ruta')->get(); // Asegúrate de tener relación con 'ruta'
        $usuarios = User::all();

        return view('sistema.lecturadores.create', compact('rutas', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'idRuta' => 'required|exists:ruta_instalaciones,id',
            'idUser' => 'required|exists:users,id',
            'periodo' => 'nullable|string|max:191',
        ]);

        // Crear el registro
        RutasLecturador::create([
            'idRuta' => $request->idRuta,
            'idUser' => $request->idUser,
            'periodo' => $request->periodo,
        ]);

        return redirect()->route('lecturadores.index')->with('success', 'Ruta asignada al lecturador exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RutasLecturador  $rutasLecturador
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            // Buscar la asignación con relaciones para mostrar detalles
            $asignacion = RutasLecturador::with(['rutaInstalacion', 'usuario'])->findOrFail($id);

            return view('sistema.lecturadores.show', compact('asignacion'));
        } catch (\Exception $e) {
            Log::error('Error en show de RutasLecturador: ' . $e->getMessage());
            return redirect()->route('lecturadores.index')->with('error', 'Asignación no encontrada.');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RutasLecturador  $rutasLecturador
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rutas = RutaInstalaciones::with('ruta')->get();
        $usuarios = User::all();

        $asignacion = RutasLecturador::findOrFail($id);
        return view('sistema.lecturadores.edit', compact('asignacion', 'rutas', 'usuarios'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'idRuta' => 'required|exists:ruta_instalaciones,id',
            'idUser' => 'required|exists:users,id',
            'periodo' => 'nullable|string|max:191',
        ]);

        $rutasLecturador = RutasLecturador::findOrFail($id);

        $rutasLecturador->idRuta = $request->idRuta;
        $rutasLecturador->idUser = $request->idUser;
        $rutasLecturador->periodo = $request->periodo;

        $rutasLecturador->save();

        return redirect()->route('lecturadores.index')
            ->with('success', 'Asignación actualizada exitosamente.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RutasLecturador  $rutasLecturador
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asignacion = RutasLecturador::findOrFail($id);
        $asignacion->delete();

        return redirect()->route('lecturadores.index')
            ->with('success', 'Asignación eliminada correctamente.');
    }

    public function restore($id)
    {
        $asignacion = RutasLecturador::onlyTrashed()->findOrFail($id);
        $asignacion->restore();

        return redirect()->route('lecturadores.index', ['restored' => true])
            ->with('success', 'Asignación restaurada correctamente.');
    }
}
