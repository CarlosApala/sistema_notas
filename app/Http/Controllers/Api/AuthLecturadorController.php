<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthLecturadorController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Intentar login usando username
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        $user = Auth::user();

        // Verificar que tenga el rol lecturador
        if (!$user->hasRole('lecturador')) {
            return response()->json([
                'message' => 'No autorizado. No es un lecturador.'
            ], 403);
        }

        // Crear token de acceso
        $token = $user->createToken('lecturador_token')->plainTextToken;

        return response()->json([
            'data' => [

                'user'  => [
                    'id'       => $user->id,
                    'username' => $user->username,
                    'name'     => $user->name

                ],
                'token' => $token

            ]
        ]);
    }
}
