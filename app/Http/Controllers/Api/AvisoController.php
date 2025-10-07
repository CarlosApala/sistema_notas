<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AvisoController extends Controller
{
    public function index(Request $request)
    {
        // Obtener usuario del header y rellenar espacios si es CHAR(5)
        $usuario = $request->header('Usuario');
        $usuario = str_pad($usuario, 5, ' ', STR_PAD_RIGHT);

        // Filtros opcionales desde la request
        $anio = $request->query('anio');   // e.g., 2025
        $mes = $request->query('mes');     // e.g., 3

        // Configuración de paginación
        $perPage = 40; // Cantidad de registros por página
        $page = $request->query('page', 1); // Número de página

        // Construir query
        $avisosQuery = DB::table('aviso')
            ->select(
                'nombre_ruta',
                'nombre_zona',
                'nomb_socio',
                'zona',
                'ruta',
                'nro_predio',
                'cod_per',
                'nro_instalacion',
                'dir_socio',
                'consumo_promedio'
            );

        // Aplicar filtros
        if ($usuario) $avisosQuery->where('usuario', $usuario);
        if ($anio) $avisosQuery->where('anio', $anio);
        if ($mes) $avisosQuery->where('mes_factura', $mes);

        // Paginación
        $avisos = $avisosQuery->paginate($perPage, ['*'], 'page', $page);

        // Transformación jerárquica: Zonas -> Rutas -> Lados -> Instalaciones
        $data = [];

        foreach ($avisos as $aviso) {
            $zonaKey = $aviso->zona;
            if (!isset($data[$zonaKey])) {
                $data[$zonaKey] = [
                    'id' => $zonaKey,
                    'nombre' => trim($aviso->nombre_zona),
                    'rutas' => []
                ];
            }

            $rutaKey = $aviso->ruta;
            if (!isset($data[$zonaKey]['rutas'][$rutaKey])) {
                $data[$zonaKey]['rutas'][$rutaKey] = [
                    'id' => $rutaKey,
                    'nombreRuta' => trim($aviso->nombre_ruta),
                    'lados' => []
                ];
            }

            // Determinar lado (A si impar, B si par)
            $lado = ($aviso->nro_predio % 2 == 0) ? 'B' : 'A';
            if (!isset($data[$zonaKey]['rutas'][$rutaKey]['lados'][$lado])) {
                $data[$zonaKey]['rutas'][$rutaKey]['lados'][$lado] = [
                    'lado' => $lado,
                    'instalaciones' => []
                ];
            }

            $data[$zonaKey]['rutas'][$rutaKey]['lados'][$lado]['instalaciones'][] = [
                'id' => $aviso->nro_instalacion,
                'numeroMedidor' => $aviso->nomb_socio,
                'estadoInstalacion' => 'Activo',
                'estadoAlcantarillado' => 'Funcional',
                'estadoCorte' => 'Sin corte',
                'promedioConsumo' => $aviso->consumo_promedio,
                'observaciones' => trim($aviso->dir_socio),
                'codigoUbicacion' => null,
                'nroGrifos' => null,
                'nroBanos' => null,
                'fechaInstalacion' => null,
                'idPredio' => $aviso->nro_predio
            ];
        }

        // Reindexar arrays para JSON limpio
        $result = [];
        foreach ($data as $zona) {
            $rutas = [];
            foreach ($zona['rutas'] as $ruta) {
                $lados = array_values($ruta['lados']);
                $ruta['lados'] = $lados;
                $rutas[] = $ruta;
            }
            $zona['rutas'] = $rutas;
            $result[] = $zona;
        }

        // Respuesta JSON final
        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $result,
            'pagination' => [
                'current_page' => $avisos->currentPage(),
                'last_page' => $avisos->lastPage(),
                'per_page' => $avisos->perPage(),
                'total' => $avisos->total()
            ]
        ]);
    }
}
