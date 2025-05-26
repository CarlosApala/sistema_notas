<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{

    //

    public function show()
    {
        if (Auth::check()) {
            return redirect('/home');
        }
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if (!$user) {
            dd('Usuario no encontrado');
        }

        /* dd([
            'Credenciales' => $credentials,
            'Usuario' => $user->only('email', 'password'),
            'Contraseña coincide' => Hash::check($credentials['password'], $user->password),
        ]);
 */
        if (!Auth::validate($credentials)) {
            dd('Credenciales inválidas');
        }

        Auth::login($user);

        return $this->authenticated($request, $user);
    }



    public function authenticated(Request $request, $user)
    {
        return redirect('/home');
    }
}
