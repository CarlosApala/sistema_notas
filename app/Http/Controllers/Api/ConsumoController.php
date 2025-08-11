<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Consumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConsumoController extends Controller
{

    public function registrarConsumo(Request $request)
    {
        $request->validate([
            'idInstalacion' => 'required|exists:instalacions,id',
            'consumo' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
            'periodo' => 'nullable|string',
            'foto' => 'nullable|image|max:51200', // 50 MB

        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            try {
                $fotoPath = $request->file('foto')->store('consumos', 'public');
            } catch (\Exception $e) {
                Log::error('Error al guardar la foto: ' . $e->getMessage());
                // Si prefieres abortar el proceso lanza throw $e;
            }
        }

        // Crear registro de consumo
        $consumo = Consumo::create([
            'idInstalacion' => $request->idInstalacion,
            'consumo' => $request->consumo,
            'foto' => $fotoPath,
            'observaciones' => $request->observaciones,
            'periodo' => $request->periodo,
            'fecha_registro' => now(),
        ]);

        $fotoUrl = $fotoPath ? asset('storage/' . $fotoPath) : null;

        // Cargar datos de la instalación para incluir en la respuesta (opcional)
        $instalacion = $consumo->instalacion;

        return response()->json([
            'status' => 200,
            'message' => 'Consumo registrado exitosamente',
            'data' => [],
        ], 201);
    }
}
