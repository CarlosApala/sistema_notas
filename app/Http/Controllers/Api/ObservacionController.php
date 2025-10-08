<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Observacion;
use Illuminate\Http\JsonResponse;

class ObservacionController extends Controller
{
    /**
     * Retorna todas las observaciones
     */
    public function index(): JsonResponse
    {
        $observaciones = Observacion::all();

        return response()->json([
            'status' => 200,
            'message' => 'Lista de observaciones obtenida correctamente.',
            'data' => $observaciones
        ], 200);
    }

    /**
     * Retorna una observación específica por su ID
     */
    public function show(int $id): JsonResponse
    {
        $observacion = Observacion::find($id);

        if (!$observacion) {
            return response()->json([
                'status' => 404,
                'message' => 'Observación no encontrada.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Observación encontrada correctamente.',
            'data' => $observacion
        ], 200);
    }
}
