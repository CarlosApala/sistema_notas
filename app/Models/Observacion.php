<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    // Nombre de la tabla
    protected $table = 'observacion';

    // Clave primaria
    protected $primaryKey = 'cod_observa';

    // No usa timestamps (created_at / updated_at)
    public $timestamps = false;

    // Campos asignables
    protected $fillable = [
        'cod_observa',
        'descripcion',
        'nro_pagina',
    ];
}
