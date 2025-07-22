<?php

namespace App\Http\Controllers;

use App\Models\RutasLecturador;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;

class UsuariosLecturadoresController extends Controller
{

    public function index(Request $request)
    {
        try {
            $user = auth()->user();

            if (!$user || !$user->can('personal_interno.ver')) {
                abort(403, 'No tienes permiso para ver este módulo');
            }

            $search = $request->input('search');
            $onlyDeleted = $request->boolean('deleted');

            $query = User::role('lecturador'); // ← filtramos por rol

            if ($onlyDeleted) {
                $query->onlyTrashed();
            }

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ilike', "%{$search}%")
                        ->orWhere('email', 'ilike', "%{$search}%")
                        ->orWhere('username', 'ilike', "%{$search}%");
                });
            }

            $usuarios = $query->orderBy('id', 'asc')
                ->paginate(10)
                ->appends($request->query());

            return Inertia::render('sistema/Usuarios_Lecturadores/Index', [
                'usuarios' => $usuarios,
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
            Log::error('Error en index de UsuariosLecturadores: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar usuarios lecturadores.');
        }
    }
    public function create()
    {
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'lecturador');
        })->get();

        return Inertia::render('sistema/Usuarios_Lecturadores/Create', [
            'users' => $users
        ]);
    }

    public function assignLecturador($id)
    {

        $user = User::findOrFail($id);

        // Verificamos si ya tiene el rol
        if ($user->hasRole('lecturador')) {
            return redirect()->back()->with('success', 'El usuario ya tiene el rol Lecturador.');
        }

        // Asignamos el rol
        $user->assignRole('lecturador');

        return redirect()->back()->with('success', 'Rol Lecturador asignado correctamente.');
    }
    public function destroy($id)
{
    try {
        $usuario = User::findOrFail($id);

        if (!$usuario->hasRole('lecturador')) {
            return redirect()->back()->with('error', 'Este usuario no tiene el rol Lecturador.');
        }

        $usuario->delete(); // Soft delete si el modelo usa SoftDeletes

        return redirect()->back()->with('success', 'Usuario lecturador eliminado correctamente.');
    } catch (\Exception $e) {
        Log::error('Error al eliminar usuario lecturador: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error al eliminar usuario lecturador.');
    }
}

}
