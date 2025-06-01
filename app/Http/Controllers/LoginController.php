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
        try {
            $credentials = $request->getCredentials();

            $user = \App\Models\User::where('email', $credentials['email'])->first();

            if (!$user || !Auth::validate($credentials)) {
                return redirect()->back()
                    ->withErrors(['email' => 'Correo o contraseña incorrectos.'])
                    ->withInput($request->only('email'));
            }

            Auth::login($user);

            return $this->authenticated($request, $user);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Ha ocurrido un error inesperado.'])
                ->withInput($request->only('email'));
        }
    }



    public function authenticated(Request $request, $user)
    {
        return redirect('/home');
    }
}
