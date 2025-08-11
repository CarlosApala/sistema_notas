<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Consumo;
use Illuminate\Http\Request;
use App\Models\RutasLecturador;
use Illuminate\Support\Facades\Log;

class RutasLecturadorApiController extends Controller
{
    public function rutasAsignadas($userId, Request $request)
{
    try {
        $periodo = $request->query('periodo'); // Ejemplo: '2025-08'

        // Obtener los idInstalacion que ya tienen consumo registrado para ese periodo
        $instalacionesConConsumo = Consumo::where('periodo', $periodo)
            ->pluck('idInstalacion')
            ->toArray();

        // Consultar las asignaciones, excluyendo instalaciones con consumo registrado
        $asignaciones = RutasLecturador::with([
                'ruta.rutaInstalaciones.predio.instalaciones',
                'usuario'
            ])
            ->where('idUser', $userId)
            ->where('periodo', $periodo)
            ->whereIn('estado', ['pendiente', 'en_progreso'])
            ->get();

        // Mapear asignaciones y filtrar instalaciones sin consumo registrado
        $data = $asignaciones->map(function ($asignacion) use ($instalacionesConConsumo) {
            $instalaciones = $asignacion->ruta->rutaInstalaciones
                ->flatMap(fn($ri) => $ri->predio->instalaciones)
                ->reject(fn($instalacion) => in_array($instalacion->id, $instalacionesConConsumo))
                ->map(function ($instalacion) {
                    return [
                        'id' => $instalacion->id,
                        'numeroMedidor' => $instalacion->NumeroMedidor,
                        'estadoInstalacion' => $instalacion->EstadoInstalacion,
                        'estadoAlcantarillado' => $instalacion->EstadoAlcantarillado,
                        'estadoCorte' => $instalacion->EstadoCorte,
                        'promedioConsumo' => $instalacion->PromedioConsumo,
                        'observaciones' => $instalacion->Observaciones,
                        'codigoUbicacion' => $instalacion->CodigoUbicacion,
                        'nroGrifos' => $instalacion->NroGrifos,
                        'nroBanos' => $instalacion->NroBaños,
                        'fechaInstalacion' => optional($instalacion->FechaInstalacion)->toDateString(),
                        'idPredio' => $instalacion->idPredio,
                    ];
                })
                ->values();

            return [
                'id' => $asignacion->id,
                'nombreRuta' => $asignacion->ruta->NombreRuta,
                'periodo' => $asignacion->periodo,
                'instalaciones' => $instalaciones,
            ];
        })
        // Filtrar para eliminar asignaciones sin instalaciones
        ->filter(fn($asignacion) => $asignacion['instalaciones']->isNotEmpty())
        ->values(); // Reindexar el array

        return response()->json([
            'message' => 'OK',
            'status' => 200,
            'data' => $data,
        ]);
    } catch (\Exception $e) {
        Log::error('Error al obtener rutas asignadas: ' . $e->getMessage());

        return response()->json([
            'message' => 'Error al obtener las rutas asignadas.',
            'status' => 500,
        ], 500);
    }
}

}
