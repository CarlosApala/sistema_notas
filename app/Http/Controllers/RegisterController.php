<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
Use App\Models\User;
use Illuminate\Support\Facades\Log;



class RegisterController extends Controller
{
    //
    public function show(){
        if(Auth::check()){
            return redirect('/home');
        }
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
{
    try {
        $user = User::create($request->validated());

        return redirect('/login')->with('success', 'Cuenta creada exitosamente');
    } catch (\Exception $e) {
        // Opcional: puedes guardar el error en los logs de Laravel
        Log::error('Error en registro: ' . $e->getMessage());

        return redirect()->back()
            ->withErrors(['error' => 'Ocurrió un error al registrar la cuenta. Inténtalo de nuevo.'])
            ->withInput(); // Mantiene los datos ya ingresados
    }
}

}
