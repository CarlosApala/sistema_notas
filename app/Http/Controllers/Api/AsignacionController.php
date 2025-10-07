<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsignacionController extends Controller
{
    public function index(Request $request)
    {
        // Obtener usuario desde el header
        $usuario = $request->header('Usuario');
        if (!$usuario) {
            return response()->json(['message' => 'Se requiere el header Usuario'], 400);
        }

        $usuario = str_pad($usuario, 5, ' ', STR_PAD_RIGHT);

        // Obtener filtros
        $anio = $request->query('anio');
        $mes  = $request->query('mes');

        // Consulta SQL
        $asignaciones = DB::table('asignacion as a')
            ->join('rutas as r', 'r.cod_ruta', '=', 'a.ruta')
            ->join('zonas as z', 'z.cod_zona', '=', 'a.zona')
            ->select(
                'a.zona as zona_id',
                'z.descripcion as zona_nombre',
                'a.ruta as ruta_id',
                'r.descripcion as ruta_nombre'
            )
            ->where('a.usuario', $usuario)
            ->when($anio, fn($q) => $q->where('a.anio', $anio))
            ->when($mes, fn($q) => $q->where('a.mes', $mes))
            ->orderBy('a.zona')
            ->orderBy('a.ruta')
            ->get();

        // Agrupar por zona
        $zonas = [];
        foreach ($asignaciones as $item) {
            $zonaId = $item->zona_id;

            if (!isset($zonas[$zonaId])) {
                $zonas[$zonaId] = [
                    'zonasId' => $zonaId,
                    'zonaNombre' => $item->zona_nombre,
                    'rutas' => []
                ];
            }

            $zonas[$zonaId]['rutas'][] = [
                'rutaId' => $item->ruta_id,
                'rutaNombre' => $item->ruta_nombre
            ];
        }

        // Estructura final
        $data = [
            [
                'anio' => $anio,
                'mes' => $mes,
                'asignaciones' => array_values($zonas)
            ]
        ];

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $data
        ]);
    }
}
