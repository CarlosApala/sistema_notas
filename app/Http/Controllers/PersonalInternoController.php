<?php

namespace App\Http\Controllers;

use App\Models\PersonalInterno;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class PersonalInternoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        try {

            $user = auth()->user();

            if (!$user || !$user->can('personal_interno.view')) {
                abort(403, 'No tienes permiso para ver este módulo');
            }

            $search = $request->input('search');
            $onlyDeleted = $request->boolean('deleted');

            $query = PersonalInterno::query();

            if ($onlyDeleted) {
                $query->onlyTrashed();
            }

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nombres', 'ilike', "%{$search}%")
                        ->orWhere('apellidos', 'ilike', "%{$search}%")
                        ->orWhere('carnet_identidad', 'ilike', "%{$search}%");
                });
            }

            $personalInterno = $query->orderBy('id', 'asc')
                ->paginate(10)
                ->appends($request->query());

            return Inertia::render('sistema/Personal_Interno/Index', [
                'personalInterno' => $personalInterno,
                'filters' => [
                    'search' => $search,
                    'deleted' => $onlyDeleted,
                ],
                'flash' => [
                    'success' => session('success'),
                    'error' => session('error'),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Error en index de PersonalInterno: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Ocurrió un error al buscar el personal interno. Intenta nuevamente.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            // Si necesitas enviar datos adicionales (por ejemplo, listas para selects), aquí puedes hacerlo.
            // En este caso, simplemente retornamos la vista sin datos adicionales.

            return Inertia::render('sistema/Personal_Interno/Create');
        } catch (\Exception $e) {
            Log::error("Error al cargar formulario de creación de personal interno: {$e->getMessage()}");
            return redirect()->back()->with('error', 'No se pudo cargar el formulario de creación.');
        }
    }

    public function getRoles()
    {
        $roles = Role::pluck('name');
        return response()->json($roles);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'carnet_identidad' => 'nullable|string|max:50|unique:personal_interno,carnet_identidad',
            'fecha_nacimiento' => 'nullable|date',
            'nacionalidad' => 'nullable|string|max:100',
            'numero_celular' => 'nullable|string|max:20',

            // Nuevos campos
            'direccion' => 'nullable|string|max:255',
            'genero' => 'nullable|in:Masculino,Femenino,Otro',
            'lugar_nacimiento' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255|unique:personal_interno,email',
        ]);


        try {
            \App\Models\PersonalInterno::create($validated);

            return redirect()
                ->route('personal_interno.index')
                ->with('success', 'Personal interno creado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar personal interno: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withErrors(['error' => 'Hubo un problema al guardar el personal interno.'])
                ->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            // Buscar el personal interno, incluyendo los eliminados (soft deletes)
            $persona = \App\Models\PersonalInterno::withTrashed()->findOrFail($id);

            return Inertia::render('sistema/Personal_Interno/Show', [
                'persona' => $persona,
            ]);
        } catch (\Exception $e) {
            Log::error("Error al mostrar el personal interno id $id: " . $e->getMessage());

            return redirect()->route('personal_interno.index')
                ->with('error', 'No se pudo cargar el personal solicitado.');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $personal = PersonalInterno::findOrFail($id);

            // Si necesitas enviar datos relacionados (por ejemplo, listas de áreas, cargos, etc.), agrégalas aquí.

            return Inertia::render('sistema/Personal_Interno/Edit', [
                'personal' => $personal,
            ]);
        } catch (\Exception $e) {
            Log::error("Error al cargar personal interno para editar: {$e->getMessage()}");
            return redirect()->back()->with('error', 'No se pudo cargar el registro de personal interno.');
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombres'          => 'required|string|max:255',
            'apellidos'        => 'required|string|max:255',
            'carnet_identidad' => 'nullable|string|max:50',
            'fecha_nacimiento' => 'nullable|date',
            'nacionalidad'     => 'nullable|string|max:100',
            'numero_celular'   => 'nullable|string|max:20',
            'direccion'        => 'nullable|string|max:255',
            'genero'           => 'nullable|in:Masculino,Femenino,Otro',
            'lugar_nacimiento' => 'nullable|string|max:255',
            'email'            => 'nullable|email|max:255|unique:personal_interno,email,' . $id,
        ]);

        try {
            $personal = PersonalInterno::findOrFail($id);
            $personal->update($request->only([
                'nombres',
                'apellidos',
                'carnet_identidad',
                'fecha_nacimiento',
                'nacionalidad',
                'numero_celular',
                'direccion',
                'genero',
                'lugar_nacimiento',
                'email',
            ]));

            return redirect()->route('personal_interno.index')->with('success', 'Personal interno actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al actualizar personal interno id $id: {$e->getMessage()}");
            return redirect()->back()->withErrors('No se pudo actualizar el personal interno.')->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalInterno $personalInterno)
    {
        try {
            $personalInterno->delete();

            return redirect()->route('personal_interno.index')
                ->with('success', 'Personal interno eliminado correctamente');
        } catch (\Exception $e) {
            Log::error("Error al eliminar personal interno id {$personalInterno->id}: {$e->getMessage()}");

            return redirect()->route('personal_interno.index')
                ->withErrors('No se pudo eliminar el personal interno.');
        }
    }
    public function restore($id)
    {
        try {
            $personalInterno = PersonalInterno::withTrashed()->findOrFail($id);
            $personalInterno->restore();

            return redirect()->route('personal_interno.index')
                ->with('success', 'Personal interno restaurado correctamente');
        } catch (\Exception $e) {
            Log::error("Error al restaurar personal interno id {$id}: {$e->getMessage()}");
            return redirect()->back()->withErrors('No se pudo restaurar el personal interno');
        }
    }
}
