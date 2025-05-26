<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensaje;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MensajeController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Mensajes asignados directamente al usuario (por la tabla intermedia)
        $mensajesAsignados = Mensaje::whereHas('usuarios', function ($query) use ($userId) {
            $query->where('id_usuario', $userId);
        });

        // Mensajes para todos
        $mensajesParaTodos = Mensaje::where('para_todos', 1);

        // Unir ambos conjuntos y obtener resultados únicos, ordenados por fecha
        $mensajes = $mensajesAsignados
            ->union($mensajesParaTodos)
            ->orderBy('fecha_envio', 'desc')
            ->get();

        return view('sistema.mensajes.index', compact('mensajes'));
    }

    public function create()
    {
        $usuarios = User::all();  // Para mostrar en el formulario
        return view('sistema.mensajes.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        // Normalizar hora_envio (de H:i a H:i:s si se ha ingresado)
        if ($request->filled('hora_envio')) {
            $hora = $request->input('hora_envio');
            if (strlen($hora) === 5) { // ej. 14:30
                $request->merge(['hora_envio' => $hora . ':00']);
            }
        }

        // Validación
        $request->validate([
            'asunto' => 'required|string|max:150',
            'contenido' => 'required|string',
            'fecha_envio' => 'required|date',
            'hora_envio' => 'nullable|date_format:H:i:s',
            'tipo_mensaje' => 'nullable|string|max:100',
            'para_todos' => 'required|boolean',
            'usuarios' => 'required_if:para_todos,0|array',
            'usuarios.*' => 'exists:users,id',
        ]);

        DB::beginTransaction();

        try {
            // Crear el mensaje
            $mensaje = Mensaje::create([
                'asunto' => $request->asunto,
                'contenido' => $request->contenido,
                'fecha_envio' => $request->fecha_envio,
                'hora_envio' => $request->hora_envio,
                'tipo_mensaje' => $request->tipo_mensaje,
                'para_todos' => $request->para_todos,
                'estado' => 1, // activo
                'id_usuario' => auth()->id(),
            ]);

            // Asociar destinatarios
            if ($request->para_todos) {
                $usuariosIds = User::pluck('id')->toArray();
                $mensaje->usuarios()->attach($usuariosIds);
            } else {
                $mensaje->usuarios()->attach($request->usuarios);
            }

            DB::commit();

            return redirect()->route('mensajes.index')->with('success', 'Mensaje enviado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error al enviar el mensaje: ' . $e->getMessage())->withInput();
        }
    }
}
