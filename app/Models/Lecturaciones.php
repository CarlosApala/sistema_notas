<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturaciones extends Model
{
    use HasFactory;
      // Nombre de la tabla
    protected $table = 'lecturaciones';

    // No usamos created_at ni updated_at
    public $timestamps = false;

    // Campos asignables en masa
    protected $fillable = [

        'mes',
        'anio',
        'numero_socio',
        'numero_predio',
        'numero_instalacion',
        'zona',
        'codigo_ruta',
        'numero_casa',
        'numero_instalacion_casa',
        'fecha_lectura',
        'codigo_observacion',
        'lectura_anterior',
        'lectura_actual',
        'consumo_promedio',
        'consumo_mes',
        'glosa',
        'estado',
        'usuario',
        'hora',
        'fecha_proceso'
    ];
}
