<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
{
    // Verifica la clave API
    $apiKey = $request->header('X-API-KEY');
    if ($apiKey !== env('API_ACCESS_KEY')) {
        return response()->json(['message' => 'Acceso no autorizado'], 403);
    }

    // Autenticación estándar
    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json(['token' => $token, 'user' => $user]);
}

}
