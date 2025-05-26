<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public function index()
    {
        $turnos = Turno::all();
        return view('sistema.turnos.index', compact('turnos'));
    }

    public function create()
    {
        return view('sistema.turnos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:turnos,nombre',
        ]);

        Turno::create($request->only('nombre'));

        return redirect()->route('turnos.index')->with('success', 'Turno creado correctamente.');
    }

    public function show(Turno $turno)
    {
        return view('turnos.show', compact('turno'));
    }

    public function edit(Turno $turno)
    {
        return view('turnos.edit', compact('turno'));
    }

    public function update(Request $request, Turno $turno)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:turnos,nombre,' . $turno->id,
        ]);

        $turno->update($request->only('nombre'));

        return redirect()->route('turnos.index')->with('success', 'Turno actualizado correctamente.');
    }

    public function destroy(Turno $turno)
    {
        $turno->delete();

        return redirect()->route('turnos.index')->with('success', 'Turno eliminado correctamente.');
    }
}
