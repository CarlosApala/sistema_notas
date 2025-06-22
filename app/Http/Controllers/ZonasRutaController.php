<?php

namespace App\Http\Controllers;

use App\Models\Rutas;
use App\Models\Zonas;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ZonasRutaController extends Controller
{
    public function index()
    {
        $zonas = Zonas::select('id', 'NombreZona')->orderByDesc('id')->paginate(10);
        $rutas = Rutas::select('id', 'NombreRuta')->orderByDesc('id')->paginate(10);

        return Inertia::render('sistema/Zonas_Rutas/Index', [
            'zonas' => $zonas,
            'rutas' => $rutas,
        ]);
    }
}
