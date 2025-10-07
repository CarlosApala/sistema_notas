<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    // Nombre de la tabla
    protected $table = 'asignacion';

    // La tabla no tiene 'id' autoincremental
    public $incrementing = false;

    // Tipo de llave primaria (no tenemos una, así que dejamos null)
    protected $primaryKey = null;

    // No tenemos timestamps en la tabla
    public $timestamps = false;

    // Campos asignables
    protected $fillable = [
        'anio',
        'mes',
        'usuario',
        'zona',
        'ruta',
    ];

    // Si quieres que Laravel trate bpchar(5) como string normal
    protected $casts = [
        'anio' => 'integer',
        'mes' => 'integer',
        'usuario' => 'string',
        'zona' => 'integer',
        'ruta' => 'integer',
    ];
}
