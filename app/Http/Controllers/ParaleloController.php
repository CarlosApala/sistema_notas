<?php

namespace App\Http\Controllers;

use App\Models\Paralelo;
use Illuminate\Http\Request;

class ParaleloController extends Controller
{
    public function index()
    {
        $paralelos = Paralelo::all();
        return view('sistema.paralelos.index', compact('paralelos'));
    }

    public function create()
    {
        return view('sistema.paralelos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:10|unique:paralelos,nombre',
        ]);

        Paralelo::create($request->only('nombre'));

        return redirect()->route('paralelos.index')->with('success', 'Paralelo creado correctamente.');
    }

    public function show(Paralelo $paralelo)
    {
        return view('sistema.paralelos.show', compact('paralelo'));
    }

    public function edit(Paralelo $paralelo)
    {
        return view('sistema.paralelos.edit', compact('paralelo'));
    }

    public function update(Request $request, Paralelo $paralelo)
    {
        $request->validate([
            'nombre' => 'required|string|max:10|unique:paralelos,nombre,' . $paralelo->id,
        ]);

        $paralelo->update($request->only('nombre'));

        return redirect()->route('paralelos.index')->with('success', 'Paralelo actualizado correctamente.');
    }

    public function destroy(Paralelo $paralelo)
    {
        $paralelo->delete();

        return redirect()->route('paralelos.index')->with('success', 'Paralelo eliminado correctamente.');
    }
}
