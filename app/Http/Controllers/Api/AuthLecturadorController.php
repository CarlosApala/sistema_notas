<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;   // <--- ESTA LÍNEA ES NECESARIA
use Illuminate\Support\Facades\Hash;  // <--- PARA HASH
use Illuminate\Support\Facades\Auth;
use App\Models\UsuarioMovil; // <-- ESTA LÍNEA ES NECESARIA

class AuthLecturadorController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'usuario' => 'required|string',
        'clave' => 'required|string',
    ]);

    // Rellenar hasta 5 caracteres con espacios
    $usuarioInput = str_pad(substr($request->usuario, 0, 5), 5, " ");
    $claveInput = str_pad(substr($request->clave, 0, 10), 10, " ");


    Log::info('Intento de login', ['usuario' => $usuarioInput]);

    // Buscar usuario con bpchar(5)
    $usuario = UsuarioMovil::where('usuario', $usuarioInput)
        ->where('estado', 0)
        ->first();
    Log::info($usuario);
    if ($usuario) {
        Log::info('Usuario encontrado', ['usuario' => $usuario->usuario]);
    } else {
        Log::warning('Usuario no encontrado', ['usuario' => $usuarioInput]);
    }

    // Validar clave
    if (!$usuario || $claveInput !== $usuario->clave) {
    return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }

    $token = $usuario->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Inicio de sesión exitoso',
        'usuario' => [
            'usuario'=>trim($usuario->usuario),
            'nombre'=>$usuario->nombre
        ],
        'token' => $token,
    ]);
}



    public function logout(Request $request)
    {
        // Elimina todos los tokens del usuario autenticado
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ]);
    }

    public function perfil(Request $request)
    {
        return response()->json($request->user());
    }
}
